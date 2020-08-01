<?php
declare (strict_types=1);

namespace app\controller\api;

use app\controller\api\Center;
use app\service\UserService;
use think\annotation\route\Middleware;
use think\annotation\route\Group;
use think\annotation\Route;
use app\middleware\CheckUser;
/**
 * 个人中心
 * Class User
 * @package app\controller\api
 * @author  kyangs@163.com
 * @Group("api/user")
 * @Middleware({CheckUser::class})
 */
class User extends Center
{
    /**
     * @Route("index", method="GET")
     */
    public function index()
    {
        echo 'user';
        var_dump($this->user->id);
    }
    /**
     * @Route("login", method="POST")
     */
    public function login()
    {
        try {
            return json_ok(UserService::userLogin($this->request->post()));
        }catch (\Exception $exception){
            return json_error(10001,$exception->getMessage());
        }
    }
}
