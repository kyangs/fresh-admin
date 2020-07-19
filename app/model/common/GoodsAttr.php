<?php
declare (strict_types=1);

namespace app\model\common;

use think\Model;
use app\traits\ModelTrait;

/**
 * 管理员
 * Class GoodsAttr
 * @package app\model
 */
class GoodsAttr extends Model
{
    use ModelTrait;
    protected $table = 'goods_attr';

    public static function deleteForSave($goodsID, $data)
    {
        self::where(['goods_id' => $goodsID])->delete();
        self::insertAll($data);
    }

    public static function findByGoodsIds($goodsIds)
    {
        if (empty($goodsIds)) return [];
        return self::whereIn('goods_id', $goodsIds)
            ->select()
            ->toArray();
    }

    public static function findByGoodsId($goodsId)
    {
        if (empty($goodsId)) return [];
        return self::where('goods_id', $goodsId)
            ->select()
            ->toArray();
    }
}



