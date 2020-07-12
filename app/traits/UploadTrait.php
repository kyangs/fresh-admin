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
     * 上传图片
     * @Route("upimg", method="POST")
     */
    public function upimg()
    {
        $file = request()->file('img');
        if (empty($file)) {
            return json_error(10010);
        }
        try {
            validate(['img' => 'fileSize:10485670|fileExt:jpg,gif,jpeg,png|fileMime:image/jpeg,image/gif,image/png'])->check(request()->file());
            //hash查重
            $hash = $file->hash('sha1');
            $img  = ImageHashService::getInfoByName($hash);
            if ($img) {
                return json_ok(['path' => $img['image']]);
            }

            //上传文件
            $savename = \think\facade\Filesystem::putFile('images', $file);
            $path     = config('filesystem.disks.aliyun.url') . DIRECTORY_SEPARATOR . $savename;
            //保存数据库
            $res = ImageHashService::save([
                'hash'  => $hash,
                'image' => $path,
                'id'    => SnowFlake::generate(),
            ]);
            if (!$res) {
                return json_error(10012);
            }
            return json_ok(['path' => $path]);
        } catch (\think\exception\ValidateException $e) {
            return json_error($e->getMessage());
        }
    }

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
            'group_id'  => $groupID,
            'file_url'  => $res['path'],
            'file_name' => $file->getOriginalName(),
            'file_size' => $file->getSize(),
            'file_type' => $file->getMime(),
            'extension' => $file->getExtension(),
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