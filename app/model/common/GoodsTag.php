<?php
declare (strict_types=1);

namespace app\model\common;

use think\Model;
use app\traits\ModelTrait;

/**
 * 管理员
 * Class GoodsTag
 * @package app\model
 */
class GoodsTag extends Model
{
    use ModelTrait;

    protected $table = 'goods_tag';

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
}



