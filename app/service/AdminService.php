<?php
declare (strict_types=1);

namespace app\service;

use app\model\Admin as AdminModel;
use app\traits\ServiceTrait;
use app\util\JwtUtil;
use app\service\AuthGroupService;

/**
 * 管理员
 * Class AdminService
 * @package app\service
 * @author  kyangs@163.com
 */
class AdminService
{
    //仓库，带命名空间
    public static $repository = 'app\repository\AdminRepository';

    use ServiceTrait;

    /**
     * 登录
     * @param string $username 用户名
     * @param string $password 未加密的密码
     * @return array 对象数组，包含字段：userToken，已编码的用户访问令牌；user，用户信息。
     * @throws \app\MyException
     */
    public static function login($username, $password)
    {
        // 查找身份，验证身份

        $user = self::$repository::getInfoByName($username);
        if (empty($user)) {
            throw new \app\MyException(11104);
        }
        //密码验证
        if ($user['password'] !== encrypt_pass($password)) {
            throw new \app\MyException(11105);
        }
        // 检测用户状态
        if ($user['is_enabled'] != true) {
            throw new \app\MyException(11106);
        }
        //权限检测
        $group = AuthGroupService::getInfoById($user['group_id']);
        if (empty($group) || $group['status'] != true) {
            throw new \app\MyException(11107);
        }
        // 数据处理和令牌获取
        $time = time();
        //登录事件
        event('AdminLogin', [$user, $group, $time]);

        // 令牌生成
        $payload['aid']        = $user['id'];
        $payload['login_time'] = $time;
        $user_token            = think_encrypt(JwtUtil::encode($payload));
        // 返回

        $data['username']    = $user['username'];
        $data['email']       = $user['email'];
        $data['realname']    = $user['realname'];
        $data['phone']       = $user['phone'];
        $data['img']         = $user['img'];
        $data['create_time'] = $user['create_time'];
        $data['login_time']  = $user['login_time'] ? date('Y-m-d H:i:s', $user['login_time']) : '';
        $data['group']       = $group['title'];

        return array('user_token' => $user_token);
    }

    /**
     * @param $request
     * @param $user
     * @return AdminModel
     * @throws \Exception
     */
    public static function saveAdmin($request, $user)
    {
        if (!isset($user['id'])) throw new \Exception('未登录，无法修改', 1);

        $data = [
            'email'    => $request['email'],
            'realname' => $request['realname'],
            'phone'    => $request['phone'],
            'img'      => $request['img'],
        ];
        if (isset($request['image_key']) && !empty($request['image_key'])) {
            $data['image_key'] = $request['image_key'];
        }

        $pwd = $request['password'];
        if (!empty($pwd)) {
            $data['password'] = encrypt_pass($pwd);
        }
        return AdminModel::update($data, ['id' => $user['id']]);
    }

}
