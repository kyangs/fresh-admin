<?php
declare (strict_types=1);

namespace app\controller\admin;

use app\controller\admin\Base;
use app\service\AdvService;
use app\service\AuthGroupService;
use app\service\AuthRuleService;
use app\traits\ControllerTrait;
use think\annotation\route\Middleware;
use think\annotation\route\Group;
use think\annotation\Route;
use app\middleware\CheckAdmin;
use app\util\TreeUtil;
use app\model\Adv as AdvModel;

/**
 * 管理员管理
 * Class Adv
 * @package app\controller\admin
 * @author  kyangs@163.com
 * @Group("admin/adv")
 * @Middleware({CheckAdmin::class})
 */
class Adv extends Base
{
    use ControllerTrait;

    /**
     * 获取登录用户信息
     * @Route("getlist", method="POST")
     * @throws \Exception
     */
    public function getlist()
    {
        return json_ok((new AdvService)->listByFilter($this->params));
    }
    /**
     * 获取登录用户信息
     * @Route("enable", method="POST")
     * @throws \Exception
     */
    public function enable()
    {
        return json_ok((new AdvService)->enable($this->params));
    }

    /**
     * 获取登录用户信息
     * @Route("param", method="POST")
     */
    public function param()
    {
        return json_ok([
            'position' => AdvModel::$position,
        ]);
    }

    /**
     * 获取登录用户信息
     * @Route("adv", method="POST")
     */
    public function saveAdv()
    {
        try {
            (new AdvService)->saveAdv($this->params,$this->user);
            return  json_ok();
        }catch (\Exception $exception){
            return json_error(10001,$exception->getMessage());
        }
    }

    /**
     * 删除信息
     * @Route("delete", method="POST")
     */
    public function deleteAdv(){
        try {
            (new AdvService)->deleteAdv($this->params);
            return  json_ok();
        }catch (\Exception $exception){
            return json_error(10001,$exception->getMessage());
        }
    }
}
