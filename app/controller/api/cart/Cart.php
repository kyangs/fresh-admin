<?php


namespace app\controller\api\cart;


use app\service\cart\CartService;
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
     * @Route("/enter", method="POST")
     */
    public function enter()
    {
        try {
            return json_ok(CartService::addCart($this->request->post()));
        } catch (\Exception $exception) {
            return json_error(10001, $exception->getMessage());
        }
    }

    /**
     * @Route("/list", method="POST")
     */
    public function cartList()
    {
        try {
            return json_ok(CartService::cartList($this->request->post()));
        } catch (\Exception $exception) {
            return json_error(10001, $exception->getMessage());
        }
    }
    /**
     * @Route("/item", method="DELETE")
     */
    public function deleteItem()
    {
        try {
            return json_ok(CartService::deleteItem($this->request->post()));
        } catch (\Exception $exception) {
            return json_error(10001, $exception->getMessage());
        }
    }
    /**
     * @Route("/item", method="PUT")
     */
    public function updateCartItem()
    {
        try {
            return json_ok(CartService::updateCartItem($this->request->post()));
        } catch (\Exception $exception) {
            return json_error(10001, $exception->getMessage());
        }
    }
    /**
     * @Route("/price", method="POST")
     */
    public function cartPrice()
    {
        try {
            return json_ok(CartService::cartPrice($this->request->post()));
        } catch (\Exception $exception) {
            return json_error(10001, $exception->getMessage());
        }
    }
}
