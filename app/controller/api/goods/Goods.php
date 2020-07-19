<?php


namespace app\controller\api\goods;

use app\service\common\CategoryService;
use app\service\common\GoodsService;
use think\annotation\route\Group;
use think\annotation\Route;
use app\controller\api\Base;

/**
 * 非用户身份类接口
 * Class Goods
 * @package app\controller\api
 * @author  kyangs@163.com
 * @Group("api/goods")
 */
class Goods extends Base
{

    /**
     * @Route("list", method="POST")
     */
    public function goodsList()
    {
        try {
            return json_ok(GoodsService::goodsList($this->params));
        } catch (\Exception $exception) {
            return json_error(10001, $exception->getMessage());
        }
    }
    /**
     * @Route("info", method="GET")
     */
    public function goodsInfo()
    {
        try {
            return json_ok(GoodsService::goodsInfo($this->request->get('goods_id')));
        } catch (\Exception $exception) {
            return json_error(10001, $exception->getMessage());
        }
    }
}