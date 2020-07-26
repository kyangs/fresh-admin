<?php


namespace app\model\common;


use app\traits\ModelTrait;
use think\Model;

class File extends Model
{
    protected $table = 'file';
    use ModelTrait;

    /** 列表
     * @param $filter
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function listByFilter($filter)
    {
        $_this = $this;
        if (isset($filter->id)) {
            $_this = $_this->where(['group_id' => $filter->id]);
        }
        return $_this->where(['is_delete' => '0'])
            ->order('id', 'desc')
            ->paginate($filter->pageSize)
            ->toArray();
    }
}
