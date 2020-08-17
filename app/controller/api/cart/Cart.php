<?php


namespace app\controller\api\cart;

use app\cart\CartService;
use app\service\common\CategoryService;
use think\annotation\route\Group;
use think\annotation\Route;
use app\controller\api\Base;

/**
 * 非用户身份类接口
 * Class Cart
 * @package app\controller\cart
 * @author  kyangs@163.com
 * @Group("api/cart")
 */
class Cart extends Base
{

    /**
     * @Route("enter", method="POST")
     */
    public function enter()
    {
        try {
            return json_ok(CartService::addCart($this->request->post()));
        } catch (\Exception $exception) {
            return json_error(10001, $exception->getMessage());
        }
    }
}