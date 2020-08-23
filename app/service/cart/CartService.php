<?php
declare (strict_types=1);

namespace app\service\cart;


use app\model\Admin as AdminModel;
use app\model\Cart;
use app\model\common\Goods;
use app\repository\cart\CartRepository;
use app\repository\goods\GoodsRepository;
use app\service\BaseService;
use app\traits\ServiceTrait;
use app\util\JwtUtil;
use app\service\AuthGroupService;

/**
 * 管理员
 * Class AdminService
 * @package app\service
 * @author  kyangs@163.com
 */
class CartService extends BaseService
{
    use ServiceTrait;

    public static function addCart($post)
    {
        if (!isset($post['user']) || empty($post['user'])) throw new \Exception('参数错误', 1);
        if (!isset($post['goodsId']) || empty($post['goodsId'])) throw new \Exception('参数错误', 1);
        $row  = CartRepository::findOneByUserIDGoodsID($post['user'], $post['goodsId']);
        $data = [
            'goods_id'     => $post['goodsId'],
            'user_id'      => $post['user'],
            'goods_number' => 1,
        ];
        if (!empty($row)) {
            $data['goods_number'] += $row['goods_number'];
            return CartRepository::edit($row['id'], $data);
        }
        return CartRepository::add($data);
    }

    /**购物车列表
     * @param $post
     * @throws \Exception
     */
    public static function cartList($post)
    {
        if (!isset($post['user_id']) || empty($post['user_id'])) throw new \Exception('参数错误', 1);

        $cartList = CartRepository::findAllByUserID($post['user_id']);
        if (empty($cartList)) return [];

        $goods = GoodsRepository::findByGoodsID(
            array_column($cartList->toArray(), 'goods_id'),
            ['create_time', 'desc'], true);
        foreach ($cartList as &$item) {
            $item['goods']   = $goods[$item['goods_id']] ?: [];
            $item['checked'] = false;
        }
        return $cartList;
    }

    public static function deleteItem($request)
    {

        if (!isset($request['id'])) {
            throw new \Exception('参数错误', 1);
        }
        return CartRepository::del($request['id']);
    }

    public static function updateCartItem($request)
    {
        if (!isset($request['id'])) {
            throw new \Exception('参数错误', 1);
        }
        if (isset($request['goods_number']) && intval($request['goods_number']) == 0) {
            throw new \Exception('参数错误', 1);
        }
        return CartRepository::edit($request['id'], [
            'goods_number' => $request['goods_number']
        ]);
    }


    public static function cartPrice($request){
        $res = [
          'orderAmount'=>0,
        ];
        if (!isset($request['cart_list']) || empty($request['cart_list'])) {
            return $res;
        }

        foreach ($request['cart_list'] as $item){
            $goods = $item['goods'] ?? [];
            if (empty($goods)) continue;
            $res['orderAmount'] += intval($item['goods_number']) * floatval($goods['price']);
        }
        return $res;
    }
}
