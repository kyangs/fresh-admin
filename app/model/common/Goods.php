<?php
declare (strict_types=1);

namespace app\model\common;

use think\Model;
use app\traits\ModelTrait;

/**
 * 管理员
 * Class Goods
 * @package app\model
 */
class Goods extends Model
{
    use ModelTrait;

    protected $table = 'goods';

    public static function goodsList($request)
    {
        $_this = new self();
        if (isset($request->goods_name) && !empty($request->goods_name)) {
            $_this = $_this->where('goods_name', 'like', '%' . $request->goods_name . '%');
        }
        if (isset($request->is_enabled)) {
            $_this = $_this->where(['is_enabled' => $request->is_enabled]);
        }
        if (isset($request->sort)) {
            $_this = $_this->order('sort', $request->sort);
        }
        if (isset($request->sale)) {
            $_this = $_this->order('sale', $request->sale);
        }
        if (isset($request->cate_id) && !empty($request->cate_id)) {
            $_this = $_this->whereIn('cate_id', $request->cate_id);
        }
        if (isset($request->time_range) && !empty($request->time_range)) {
            $_this = $_this->whereBetween('create_time', $request->time_range);
        }
        return $_this->paginate($request->pageSize)
            ->toArray();
    }

    public static function goodsInfoByID($goodsId)
    {
        return self::where(['id' => $goodsId])->find()->toArray();
    }

    public static function enabled($goodsId, $enable)
    {
        return self::update([
            'is_enabled' => $enable,
        ], ['id' => $goodsId]);
    }

    public static function deleteById($goodsId)
    {
        return self::where(['id' => $goodsId])->delete();
    }
}



