<?php
declare (strict_types=1);

namespace app\cart;

use think\Model;
use think\model\concern\SoftDelete;
use app\traits\ModelTrait;

/**
 * 管理员
 * Class Admin
 * @package app\model
 * @author  kyangs@163.com
 */
class Cart extends Model
{
    //据输出显示的属性
    public static $showField = [
        'id',
        'user_id',
        'goods_id',
        'goods_number',
        'update_time',
        'create_time',
    ];
    use ModelTrait;
}



