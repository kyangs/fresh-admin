<?php
declare (strict_types=1);

namespace app\traits;

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
        $upload = new  UploadService;
        $file = request()->file('file');
        return json_ok($upload->upload($file->getPathname(), $file->getOriginalName(), $file->getMime()));
    }


}