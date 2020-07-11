<?php
declare (strict_types=1);

namespace app\model\common;

use think\Model;
use app\traits\ModelTrait;

/**
 * 管理员
 * Class Category
 * @package app\model
 */
class Category extends Model
{
    use ModelTrait;

    /**
     * @param int $parentID
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function category($parentID = 0)
    {
        if ($parentID > 0) {
            return self::where('parent_id', '>', $parentID)->order('sort', 'asc')->select()->toArray();
        }
        return self::where(['parent_id' => $parentID])->order('sort', 'asc')->select()->toArray();
    }


    /**
     * @param $filter
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function categoryByFilter($filter)
    {
        $_this = (new self());
        if (isset($filter['parent_id'])) {
            $_this = $_this->where(['parent_id' => $filter['parent_id']]);
        }
        if (isset($filter['show_home'])) {
            $_this = $_this->where(['show_home' => $filter['show_home']]);
        }
        if (isset($filter['is_enabled'])) {
            $_this = $_this->where(['is_enabled' => $filter['is_enabled']]);
        }
        return $_this->order('sort', 'asc')->select()->toArray();
    }

    public static function deleteByIds($ids)
    {
        return self::whereIn('id', $ids)->delete();
    }
}



