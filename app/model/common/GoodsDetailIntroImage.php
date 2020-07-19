<?php
declare (strict_types=1);

namespace app\model\common;

use think\Model;
use app\traits\ModelTrait;

/**
 * 管理员
 * Class GoodsDetailIntroImage
 * @package app\model
 */
class GoodsDetailIntroImage extends Model
{
    use ModelTrait;

    // 类型：carousel ：轮播，detail:详情图片
    protected $table = 'goods_detail_intro_image';

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



