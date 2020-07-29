<?php
declare (strict_types=1);

namespace app\service\user;

use app\model\common\SystemSetting;
use app\model\User;
use app\repository\system\SystemSettingRepository;
use app\repository\user\UserRepository;
use app\service\BaseService;
use app\service\UserService;
use app\validate\UserValidate;
use think\facade\Config;
use EasyWeChat\Factory;
use think\facade\Db;

/**
 * 微信小程序用户
 * Class UserWechatService
 * @package app\service\user
 * @author  kyangs@163.com
 */
class UserMiniService extends BaseService
{

    public static function getUserList($request)
    {
        $where = [];
        if ($request->username) {
            $where[] = ['nickname', 'like', '%' . $request->username . '%'];
        }
        if ($request->phone) {
            $where[] = ['phone', 'like', '%' . $request->phone . '%'];
        }
        if ($request->time_range && !empty($request->time_range)) {
            $where[] = ['create_time', 'between', [$request->time_range[0], $request->time_range[1]]];
        }
        $data = UserRepository::paginate($where, ['create_time' => 'desc'], $request->current_page, $request->per_page);

        foreach ($data['data'] as &$item) {
            $item['full_avatar'] = SystemSettingRepository::fullPath($item['avatar'], $item['image_key']);
        }
        return $data;
    }

    /**
     * 微信用户自动登录
     * @param $openid
     */
    public static function login($openid)
    {
        // 查找身份，验证身份
        $user = UserService::getInfoByName($openid);
        if (empty($user)) {
            throw new \app\MyException(11104);
        }
        // 检测用户状态
        if ($user['is_enabled'] != true) {
            throw new \app\MyException(11106);
        }
        return UserService::getToken($user['id'], time());
    }


    /**
     * 注册用户
     * @param $phone
     * @param $data
     * @throws \app\MyException
     */
    public static function register($phone, $data)
    {
        //1.组装信息
        $info['phone']    = $phone;
        $info['openid']   = $data['openId'];
        $info['avatar']   = $data['avatarUrl'];
        $info['gender']   = $data['gender'];
        $info['realname'] = $data['nickName'];

        //2检测openid
        $user = UserService::getInfoByName($info['openid']);
        if ($user) {
            throw new \app\MyException(12001);
        }

        //3.检测手机号，存在则更新信息
        $user = UserService::getInfoByPhone($phone);
        if ($user) {
            $res = self::save([
                'openid' => $data['openId'],
                'avatar' => $data['avatarUrl'],
                'gender' => $data['gender']
            ], $user['id']);

            if ($res) {
                return UserService::getToken($user['id'], time());
            } else {
                throw new \app\MyException(12002);
            }
        }

        //4.注册新用户
        $userid = self::save($info);
        if ($userid) {
            return UserService::getToken($userid, time());
        } else {
            throw new \app\MyException(12002);
        }

    }

    /**
     * 小程序code换取session_key
     * @param $code
     * @return array
     * @throws \app\MyException
     */
    public static function getSessionByCode($code)
    {
        $option = Config::get("app.wechat_mini");
        $app    = Factory::miniProgram($option);

        try {
            $res = $app->auth->session($code);
            $res = json_decode(json_encode($res), true);
            if (isset($res) && isset($res['openid']) && $res['session_key']) {

                return ['key' => $res['session_key'], 'openid' => $res['openid']];

            } else {
                throw new \app\MyException(12003);
            }
        } catch (\Exception $e) {
            throw new \app\MyException(12003);
        }
    }

    /**
     * 解析数据
     * @param $key
     * @param $rawData
     * @param $sign
     * @param $encryptedData
     * @param $iv
     * @return array
     * @throws \think\Exception
     */
    public static function getDecryptData($key, $rawData, $sign, $encryptedData, $iv)
    {
        //1.校验数据的完整性
        $session_key = think_decrypt($key);
        if (empty($session_key)) {
            throw new \app\MyException(12004);
        }
        $signature = sha1($rawData . $session_key);
        if ($signature !== $sign) {
            throw new \app\MyException(12005);
        }

        $option = Config::get("app.wechat_mini");
        $app    = Factory::miniProgram($option);
        try {
            $decryptedData = $app->encryptor->decryptData($session_key, $iv, $encryptedData);
            if (empty($decryptedData) || empty($decryptedData['openId'])) {
                throw new \app\MyException(12006);
            }
            return $decryptedData;
        } catch (\Exception $e) {
            throw new \app\MyException(12006);
        }
    }

    /**
     * 解析手机号数据
     * @param $key
     * @param $encryptedData
     * @param $iv
     * @return array
     * @throws \think\Exception
     */
    public static function getDecryptPhone($key, $encryptedData, $iv)
    {
        //1.校验数据的完整性
        $session_key = think_decrypt($key);

        $option = Config::get("app.wechat_mini");
        $app    = Factory::miniProgram($option);
        try {
            $decryptedData = $app->encryptor->decryptData($session_key, $iv, $encryptedData);
            if (empty($decryptedData) || empty($decryptedData['phoneNumber'])) {
                throw new \app\MyException(12006);
            }
            return $decryptedData;
        } catch (\Exception $e) {
            throw new \app\MyException(12006);
        }
    }

    /** 管理员保存在用户
     * @param $request
     * @return mixed
     */
    public static function adminSaveUser($request)
    {
        $data = [
            'nickname'   => $request->nickname,
            'real_name'  => $request->real_name,
            'avatar'     => $request->avatar,
            'image_key'  => $request->image_key,
            'phone'      => $request->phone,
            'gender'     => $request->gender,
            'is_enabled' => $request->is_enabled,
        ];
        $phoneRule='unique:user,phone';
        if (isset($request->id) && !empty($request->id)){
            $phoneRule.=','.$request->id;
        }
        if (isset($request->password) && !empty($request->password)) {
            $data['password'] = think_encrypt($request->password);
        }
        validate(UserValidate::class)->rule('phone',$phoneRule)->check($data);
        if ($request->id && !empty($request->id)) {
            return UserRepository::edit($request->id, $data);
        }
        return UserRepository::add($data);
    }


    /**删除用户
     * @param $request
     * @return int
     * @throws \Exception
     */
    public static function deleteUser($request)
    {
        if ($request->id && !empty($request->id)) {

            return UserRepository::del($request->id);
        }
        throw new \Exception('传入参数错误', 1);
    }

}
