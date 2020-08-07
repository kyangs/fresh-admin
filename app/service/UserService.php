<?php
declare (strict_types=1);

namespace app\service;

use app\model\common\SystemSetting;
use app\repository\system\SystemSettingRepository;
use app\repository\user\UserRepository;
use app\traits\ServiceTrait;
use app\util\JwtUtil;
use app\validate\UserValidate;

/**
 * 用户
 * Class UserService
 * @package app\service
 * @author  kyangs@163.com
 */
class UserService
{
    //仓库，带命名空间
    public static $repository = 'app\repository\UserRepository';

    use ServiceTrait;


    /**
     * 获取用户身份token
     * @param $user 用户信息
     */
    public static function getToken($uid, $time)
    {
        //登录事件
        event('UserLogin', [$uid, $time]);

        // 令牌生成
        $payload['uid']        = $uid;
        $payload['login_time'] = $time;
        $user_token            = think_encrypt(JwtUtil::encode($payload));
        // 返回
        return $user_token;
    }

    /**
     * 通过手机号获取信息
     * @param $phone
     */
    public static function getInfoByPhone($phone, $field = [])
    {
        return self::$repository::getInfoByPhone($phone, $field);
    }


    /**
     * @param $post
     * @return object
     * @throws \Exception
     */
    public static function userLogin($post)
    {
        $userInfo = null;
        switch ($post['loginMode']) {
            case UserRepository::LOGIN_MODE_MODE:
                $userInfo = self::passwordLogin($post['account'], $post['password']);
                break;
            case UserRepository::LOGIN_MODE_SMS:
                $userInfo = self::smsLogin($post['account'], $post['smsCode']);
                break;
        }
        if (empty($userInfo)) throw new \Exception('登录失败', 1);
        self::loginEvent($userInfo['id']);
        return $userInfo;

    }

    /**
     * @param $account
     * @param $password
     * @return object
     * @throws \Exception
     */
    public static function passwordLogin($account, $password)
    {
        $userRow = UserRepository::getByAccountOrPhone($account, $account);

        if (empty($userRow)) throw new \Exception('用户不存在或账号密码错误', 1);

        if (!empty($userRow)) {
            $userRow['full_avatar'] = SystemSettingRepository::fullPath($userRow['avatar'], $userRow['image_key']);
        }

        if (think_decrypt($userRow['password']) != $password) {
            throw new \Exception('用户不存在或账号密码错误', 1);
        }
        return $userRow;
    }

    /**
     * @param $phone
     * @param $code
     * @throws \Exception
     */
    public static function smsLogin($phone, $code)
    {
        $cacheCode = cache($phone);
        if (empty($cacheCode)) {
            throw new \Exception('验证码已失效', 1);
        }
        if ($cacheCode != $code) {
            throw new \Exception('验证码错误');
        }
        $userRow = UserRepository::getByAccountOrPhone($phone, $phone);
        if (empty($userRow)) { // 如果 为空说明是新用户，此时要自动创建一条用户记录，以便登录
            $userRow = UserRepository::add([
                'account' => $phone,
                'phone'   => $phone,
                'reg_ip'  => request()->ip(),
            ]);
        }
        if (empty($userRow)) throw new \Exception('登录失败', 1);

        if (isset($userRow['full_avatar']) && !empty($userRow['full_avatar'])) {
            $userRow['full_avatar'] = SystemSettingRepository::fullPath($userRow['avatar'], $userRow['image_key']);
        }
        cache($phone, null);
        return $userRow;
    }

    /** 登录事件
     * @param $uid
     */
    public static function loginEvent($uid)
    {
        UserRepository::edit($uid, [
            'login_ip'   => request()->ip(),
            'login_time' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * @param $get
     * @return array|mixed
     */
    public static function defaultIconList($get)
    {
        $settingRow = SystemSettingRepository::setting(SystemSetting::SETTING_DEFAULT_AVATAR);
        if (!empty($settingRow)) {
            $settingRow['avatar'] = SystemSettingRepository::fullPath($settingRow['avatar'], $settingRow['image_key']);
        }
        return [
            'avatar' => $settingRow,
        ];
    }

    /**
     * @param $userInfo
     * @param array $file
     * @return array|mixed
     * @throws \Exception
     */
    public static function modifyUserInfo($userInfo, $file = [])
    {
        if (!isset($userInfo['id'])) throw new \Exception('登录已经失效,请重新登录', 1);
        $id     = $userInfo['id'];
        $update = [
            'nickname'  => $userInfo['nickname'],
            'account'   => $userInfo['account'],
            'real_name' => $userInfo['real_name'],
            'birth'     => $userInfo['birth'],
            'gender'    => $userInfo['gender'],
            'image_key' => $userInfo['image_key'],
            'avatar'    => $userInfo['avatar'],
            'sign'      => $userInfo['sign'],
        ];
        $file   = empty($file) ? [] : $file;
        if (empty($file) && isset($_FILES['file'])) {
            $file = $_FILES['file'];
        }
        if (isset($file['tmp_name'])) {
            $data                = UploadService::upload($file['tmp_name'], $file['name'], $file['type']);
            $update['image_key'] = $data['config_key'];
            $update['avatar']    = $data['path'];
        }
        $validate = validate(UserValidate::class);
        if (isset($userInfo['modifyPhone']) && $userInfo['modifyPhone']) {
            if (!isset($userInfo['smsCode']) || empty($userInfo['smsCode'])) {
                throw new \Exception('请输入验证码', 1);
            }
            $cacheCode = cache($userInfo['phone']);
            if (empty($cacheCode)) {
                throw new \Exception('验证码已失效', 1);
            }
            if ($cacheCode != $userInfo['smsCode']) {
                throw new \Exception('验证码不正确', 1);
            }
            $update['phone'] = $userInfo['phone'];
            $validate->rule('phone', 'unique:user,phone,' . $id);
        }
        $validate->rule('account', 'unique:user,account,' . $id);
        if (isset($userInfo['password']) && !empty($userInfo['password'])) {
            $update['password'] = think_encrypt($userInfo['password']);
        }
        $validate->check($update);
        $userInfo                = UserRepository::edit($id, $update);
        $userInfo['full_avatar'] = SystemSettingRepository::fullPath($userInfo['avatar'], $userInfo['image_key']);
        $userInfo['id']          = $id;
        cache($userInfo['phone'], null);
        return $userInfo;
    }

}
