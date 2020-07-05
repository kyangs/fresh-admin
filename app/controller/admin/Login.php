<?php
declare (strict_types=1);

namespace app\controller\admin;

use app\BaseController;
use app\service\AdminService;
use think\annotation\route\Group;
use think\annotation\Route;

/**
 * 登陆
 * Class Login
 * @package app\controller\admin
 * @author  kyangs@163.com
 * @Group("admin/login")
 */
class Login extends BaseController
{
    /**
     * 登录
     * @Route("index", method="POST")
     */
    public function index()
    {
        //接收数据
        $data = [
            'username' => input('username', '', 'trim'),
            'password' => input('password', '', 'trim'),
        ];
        if (empty($data['username'])) {
            return json_error(12007);
        }
        if (empty($data['password'])) {
            return json_error(12008);
        }
        // 登录验证并获取包含访问令牌的用户
        $result = AdminService::login($data['username'], $data['password']);
        return json_ok($result, 11108);
    }


}
