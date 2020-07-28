<?php
declare (strict_types=1);

namespace app\controller\admin\user;

use app\controller\admin\Base;
use app\service\AdminService;
use app\service\AuthGroupService;
use app\service\AuthRuleService;
use app\service\UploadService;
use app\service\user\UserMiniService;
use app\traits\ControllerTrait;
use think\annotation\route\Middleware;
use think\annotation\route\Group;
use think\annotation\Route;
use app\middleware\CheckAdmin;
use app\util\TreeUtil;
use app\model\Admin as AdminModel;

/**
 * 管理员管理
 * Class User
 * @package app\controller\admin
 * @author  kyangs@163.com
 * @Group("admin/user")
 * @Middleware({CheckAdmin::class})
 */
class User extends Base
{
    /**
     * 获取登录用户列表
     * @Route("list", method="POST")
     */
    public function getUserList()
    {
        try {
            return json_ok(UserMiniService::getUserList($this->params));
        } catch (\Exception $exception) {
            return json_error(10002, $exception->getMessage());
        }
    }


    /**
     * 保存登录用户
     * @Route("save", method="POST")
     */
    public function saveUser(){
        try {
            return json_ok(UserMiniService::adminSaveUser($this->params));
        } catch (\Exception $exception) {
            return json_error(10002, $exception->getMessage());
        }
    }

}
