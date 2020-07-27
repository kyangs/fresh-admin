<?php
declare (strict_types=1);

namespace app\repository\file;

use app\model\common\SystemSetting;
use app\traits\RepositoryTrait;
use Aws\S3\S3Client;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

/**
 * 管理员
 * Class QiniuFileRepository
 * @package app\repository\file
 * @author  kyangs@163.com
 */
class QiniuFileRepository extends FileRepository
{

    protected $setting;

    public function __construct($setting)
    {
        $this->setting = $setting;
    }


    public function upload($sourceFile, $sourceName = '', $type = 'image/jpeg')
    {
        try {
            // 要上传图片的本地路径
            $realPath = $sourceFile;

            // 构建鉴权对象
            $auth = new Auth($this->setting['accessKeyId'], $this->setting['accessKeySecret']);

            // 要上传的空间
            $token = $auth->uploadToken($this->setting['bucket']);

            // 初始化 UploadManager 对象并进行文件的上传
            $uploadMgr = new UploadManager();

            // 调用 UploadManager 的 putFile 方法进行文件的上传
            list($result, $error) = $uploadMgr->putFile($token, $sourceName, $realPath);
            if ($error !== null) throw new \Exception('上传失败', 1);
            return [
                'path'      => $sourceName,
                'full_path' => rtrim($this->setting['http'], '/') . '/' . $sourceName,
            ];
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

}
