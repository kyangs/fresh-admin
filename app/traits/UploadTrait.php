<?php
declare (strict_types=1);

namespace app\traits;

use app\model\common\File;
use app\model\common\FileGroup;
use app\service\ImageHashService;
use app\service\UploadService;
use think\facade\SnowFlake;
use think\annotation\Route;

/**
 * 文件上传公共方法
 * Trait UploadTrait
 * @package app\traits
 */
trait UploadTrait
{
    /**
     * 上传文件
     * @Route("upload", method="POST")
     * @throws \Exception
     */
    public function upload()
    {
        $fileGroup = new FileGroup;
        $groupID   = $fileGroup->where(['id' => request()->post(['id'])])->value('id');
        if (empty($groupID)) throw new \Exception('分组不存在', 1);
        $file                 = request()->file('file');
        $res                  = UploadService::upload(
            $file->getPathname(),
            $file->getOriginalName(),
            $file->getMime());
        $fileRow              = File::create([
            'group_id'   => $groupID,
            'file_url'   => $res['path'],
            'config_key' => $res['config_key'],
            'file_name'  => $file->getOriginalName(),
            'file_size'  => $file->getSize(),
            'file_type'  => $file->getMime(),
            'extension'  => $file->getExtension(),
        ])->toArray();
        $fileRow['full_url']  = $res['full_path'];
        $fileRow['file_size'] = round($fileRow['file_size'] / 1024, 2) . 'KB';;
        return json_ok($fileRow);
    }

    /**
     * 上传文件
     * @Route("avatar", method="POST")
     * @throws \Exception
     */
    public function uploadAvatar()
    {
        $file             = request()->file('file');
        $res              = UploadService::upload(
            $file->getPathname(),
            $file->getOriginalName(),
            $file->getMime());
        $res['full_url']  = $res['full_path'];
        $res['file_size'] = round($file->getSize() / 1024, 2) . 'KB';;
        return json_ok($res);
    }


}
