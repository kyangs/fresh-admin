<?php
declare (strict_types=1);

namespace app\model\common;

use think\Model;
use app\traits\ModelTrait;

/**
 * 管理员
 * Class GoodsSales
 * @package app\model
 */
class GoodsSales extends Model
{
    use ModelTrait;

    protected $table = 'goods_sales';

    public static function getMothSalesByGoodsID($goodsId)
    {
        if (empty($goodsId)) return 0;
        $endTime   = date('Y-m-d H:i:s');
        $startTime = date('Y-m-d H:i:s', strtotime('-30 day'));
        return self::where('goods_id', $goodsId)
            ->whereBetween('create_time', [$startTime, $endTime])
            ->sum('num');
    }
}



