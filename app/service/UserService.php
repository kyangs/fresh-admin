<?php
declare (strict_types=1);

namespace app\service;

use app\model\common\SystemSetting;
use app\repository\system\SystemSettingRepository;
use app\repository\user\UserRepository;
use app\traits\ServiceTrait;
use app\util\JwtUtil;

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


    public static function userLogin($post)
    {
        $userRow = UserRepository::getByAccountOrPhone($post['account'], $post['account']);

        if (empty($userRow)) throw new \Exception('用户不存在或账号密码错误', 1);

        if (!empty($userRow)) {
            $userRow['full_avatar'] = SystemSettingRepository::fullPath($userRow['avatar'], $userRow['image_key']);
        }
        if (think_decrypt($userRow['password']) != $post['password']) {
            throw new \Exception('用户不存在或账号密码错误', 1);
        }
        return $userRow;
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
            'phone'     => $userInfo['phone'],
            'real_name' => $userInfo['real_name'],
            'birth'     => $userInfo['birth'],
            'gender'    => $userInfo['gender'],
            'image_key' => $userInfo['image_key'],
            'avatar'    => $userInfo['avatar'],
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
        $userInfo = UserRepository::edit($id, $update);
        $userInfo['full_avatar'] = SystemSettingRepository::fullPath($userInfo['avatar'], $userInfo['image_key']);
        $userInfo['id']          = $id;
        return $userInfo;
    }

}
