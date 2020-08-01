<?php
declare (strict_types=1);

namespace app\service;

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

}
