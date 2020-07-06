<?php


namespace app\service\common;


use app\model\common\File;
use app\model\common\FileGroup;
use app\service\BaseService;
use app\service\UploadService;

class FileService extends BaseService
{

    /** 列表
     * @param $post
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getFileList($post)
    {
        $groupList = (new FileGroup)->listByFilter();
        $first     = current($groupList);
        if (!isset($first['id'])) {
            $post->group_id = $first['id'];
        }
        $file = (new File)->listByFilter($post);
        foreach ($file as &$f) {
            $f['file_full_url'] = UploadService::fullPath($f['file_url']);
        }
        return [
            'table_data' => $file,
            'group_list' => $groupList,
        ];
    }

    /**组列表
     * @param $post
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getGroup($post)
    {

        return [
            'group_list' => (new FileGroup)->listByFilter(),
        ];
    }

    /**
     * @param $post
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function saveGroup($post)
    {
        $FileGroup = new FileGroup();
        return [
            'group' => $FileGroup->saveGroup($post),
        ];
    }
}