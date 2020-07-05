<?php
declare (strict_types=1);

namespace app\model;

use think\Model;
use app\traits\ModelTrait;

/**
 * 管理员
 * Class Adv
 * @package app\model
 */
class Adv extends Model
{
    use ModelTrait;

    public static $position = [
        'home'   => '首页',
        'detail' => '商品详情页',
        'center' => '个人中心页',
        'cart'   => '购物车页',
    ];
}



