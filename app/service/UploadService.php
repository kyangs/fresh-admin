<?php


namespace app\service;


use Aws\S3\S3Client;

class UploadService
{

    const ACL_PUBLIC_READ = 'public-read';
    private static $s3UploadClient;
    private static $bucketName;

    /**
     * 构造方法
     * Qiniu constructor.
     */
    private function __construct()
    {

    }

    private static function init()
    {
        if (empty(self::$s3UploadClient)) {
            self::$s3UploadClient = new S3Client([
                'version'                 => 'latest',
                'region'                  => 'us-east-1',
                'endpoint'                => config('filesystem.disks.minio.endpoint'),
                'use_path_style_endpoint' => true,
                'credentials'             => [
                    'key'    => config('filesystem.disks.minio.accessId'),
                    'secret' => config('filesystem.disks.minio.accessSecret'),
                ],
            ]);
            self::$bucketName     = config('filesystem.disks.minio.bucket');
        }
    }

    /**
     * 执行上传
     * @param $sourceFile
     * @param string $sourceName
     * @param string $type
     * @return bool|mixed
     * @throws \Exception
     */

    public static function upload($sourceFile, $sourceName = '', $type = 'image/jpeg')
    {
        try {
            self::init();
            //$module, $sourceFilePath, $originName, $acl = self::ACL_PUBLIC_READ
            // 要上传图片的本地路径
            $uploadFilePath = date('Y-m') . '/' . $sourceName;
            $result         = self::$s3UploadClient->putObject([
                'Bucket'      => self::$bucketName,
                'Key'         => $uploadFilePath,
                'SourceFile'  => $sourceFile,
                'ACL'         => self::ACL_PUBLIC_READ,
                'ContentType' => $type
            ]);

            return [
                'path'      => self::$bucketName . '/' . $uploadFilePath,
                'full_path' => $result->get('ObjectURL'),
            ];
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public static function getEndpoint()
    {
        return rtrim(config('filesystem.disks.minio.endpoint'), '/') . '/';
    }

    public static function fullPath($path)
    {
        return self::getEndpoint() . $path;
    }
}