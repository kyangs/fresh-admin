<?php


namespace app\model\common;


use app\traits\ModelTrait;
use think\Model;

class FileGroup extends Model
{
    protected $table = 'file_group';
    use ModelTrait;


    /** 列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function listByFilter()
    {
        return $this->order('sort', 'asc')->select()->toArray();
    }

    /**
     * @param $post `group_type`  varchar(10)      NOT NULL DEFAULT '' COMMENT '文件类型',
     * `group_name`  varchar(30)      NOT NULL DEFAULT '' COMMENT '分类名称',
     * `sort`        int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类排序(数字越小越靠前)',
     * `wxapp_id`    int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
     * @throws \Exception
     */
    public function saveGroup($post)
    {
        if (empty($post->group_nam)) throw new \Exception('请输入组名', 1);
        $data = [
            'group_name' => $post->group_name,
            'sort'       => $post->sort,
        ];
        if (!empty($post->id)) {

            return self::update($data, ['id' => $post->id]);
        }
        $row = $this->where(['group_name' => $post->group_name])->value('id');
        if (!empty($row)) throw new \Exception('组名已经存在', 1);

        return self::create($data);
    }

    /** 删除
     * @param $post
     * @return bool
     * @throws \Exception
     */
    public function deleteGroup($post)
    {
        if (!empty($post->id)) {
            return self::where(['id' => $post->id])->delete();
        }
        throw new \Exception('参数错误', 1);
    }
}
