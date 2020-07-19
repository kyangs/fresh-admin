<?php
declare (strict_types=1);

namespace app\controller\admin;

use app\controller\admin\Base;
use app\service\AdvService;
use app\service\AuthGroupService;
use app\service\AuthRuleService;
use app\service\common\GoodsService;
use app\traits\ControllerTrait;
use think\annotation\route\Middleware;
use think\annotation\route\Group;
use think\annotation\Route;
use app\middleware\CheckAdmin;
use app\util\TreeUtil;
use app\model\Adv as AdvModel;

/**
 * 管理员管理
 * Class Goods
 * @package app\controller\admin
 * @author  kyangs@163.com
 * @Group("admin/goods")
 * @Middleware({CheckAdmin::class})
 */
class Goods extends Base
{
    use ControllerTrait;

    /**
     * 保存商品
     * @Route("save", method="POST")
     * @throws \Exception
     */
    public function saveGoods()
    {
        return json_ok(GoodsService::saveGoods($this->params));
    }
    /**
     * 保存商品
     * @Route("enable", method="POST")
     * @throws \Exception
     */
    public function enabled()
    {
        try {
            return json_ok(GoodsService::enabled($this->params));
        }catch (\Exception $exception){
            return json_error(10001,$exception->getMessage());
        }
    }
    /**
     * 保存商品
     * @Route("info", method="POST")
     * @throws \Exception
     */
    public function goodsInfo()
    {
        try {
            return json_ok(GoodsService::goodsInfo($this->params->id));
        }catch (\Exception $exception){
            return json_error(10001,$exception->getMessage());
        }
    }
    /**
     * 获取登录用户信息
     * @Route("list", method="POST")
     * @throws \Exception
     */
    public function goodsList()
    {
        return json_ok(GoodsService::goodsList($this->params));
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
     * 删除信息
     * @Route("delete", method="POST")
     */
    public function deleteGoods(){
        try {
            GoodsService::delete($this->params);
            return  json_ok();
        }catch (\Exception $exception){
            return json_error(10001,$exception->getMessage());
        }
    }
}
