<?php
declare (strict_types=1);

namespace app\model\common;

use think\Model;
use app\traits\ModelTrait;

/**
 * 管理员
 * Class GoodsImage
 * @package app\model
 */
class GoodsImage extends Model
{
    use ModelTrait;

    // 类型：carousel ：轮播，detail:详情图片
    const TYPE_CAROUSEL = 'carousel';
    const TYPE_DETAIL = 'detail';
    protected $table = 'goods_image';

    public static function deleteForSave($goodsID, $data)
    {
        self::where(['goods_id' => $goodsID])->delete();
        self::insertAll($data);
    }

    public static function findByGoodsIds($goodsIds)
    {
        if (empty($goodsIds)) return [];
        return self::whereIn('goods_id', $goodsIds)
            ->whereIn('type', [self::TYPE_CAROUSEL, self::TYPE_DETAIL])
            ->select()
            ->toArray();
    }
}



