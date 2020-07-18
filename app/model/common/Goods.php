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
            $_this = $_this->where(['is_enabled'=>$request->is_enabled]);
        }
        if (isset($request->sort)) {
            $_this = $_this->order('sort',$request->sort);
        }
        if (isset($request->sale)) {
            $_this = $_this->order('sale',$request->sale);
        }
        if (isset($request->cate_id)) {
            $_this = $_this->whereIn('cate_id',$request->cate_id);
        }
        return $_this->paginate($request->pageSize)
            ->toArray();
    }
}



