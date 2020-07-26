<?php


namespace app\service\common;


use app\model\common\File;
use app\model\common\FileGroup;
use app\repository\file\FileSystemRepository;
use app\service\BaseService;

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
        return FileSystemRepository::listByFilter($post);
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
     * @throws \Exception
     */
    public function saveGroup($post)
    {
        $FileGroup = new FileGroup();
        $FileGroup->saveGroup($post);
        return $this->getGroup($post);
    }

    /** 删除组
     * @param $post
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function deleteGroup($post)
    {
        $FileGroup = new FileGroup();
        $FileGroup->deleteGroup($post);
        return $this->getGroup($post);
    }

    /**
     * @param $post
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function deleteFile($post)
    {
        $FileGroup = new File();
        $FileGroup->deleteFile($post->id_list);
        return $this->getFileList($post->group);
    }
}
