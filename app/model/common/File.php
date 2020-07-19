<?php


namespace app\model\common;


use app\controller\admin\Upload;
use app\service\UploadService;
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

    /**
     * @param $idList
     * @return File|bool
     */
    public function deleteFile($idList)
    {
        if (empty($idList)) return false;
        return self::update([
            'is_delete' => 1,
        ], ['id' => $idList]);
    }

    /** 文件列表 以id 为key
     * @param $imageIds
     * @param bool $onlyUrl
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function findByIds($imageIds, $onlyUrl = false)
    {
        $imgList = [];
        if (empty($imageIds)) return $imgList;

        $httpPrefix = rtrim(config('filesystem.disks.minio.endpoint'), '/') . '/';
        foreach (self::where(['id' => $imageIds])->select()->toArray() as &$item) {
            $item['full_url']     = $httpPrefix . $item['file_url'];
            $imgList[$item['id']] = $onlyUrl ? $item['full_url'] : $item;
        }
        return $imgList;


    }

    public static function findById($imageIds, $onlyUrl = true)
    {

        if (empty($imageIds)) return '';

        $httpPrefix      = rtrim(config('filesystem.disks.minio.endpoint'), '/') . '/';
        $row             = self::where(['id' => $imageIds])->find()->toArray();
        $row['full_url'] = $httpPrefix . $row['file_url'];
        return $onlyUrl ? $row['full_url'] : $row;
    }
}
