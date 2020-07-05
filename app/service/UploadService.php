<?php


namespace app\service;


use Aws\S3\S3Client;

class UploadService
{

    const ACL_PUBLIC_READ = 'public-read';
    private $s3UploadClient;
    private $bucketName;

    /**
     * 构造方法
     * Qiniu constructor.
     */
    public function __construct()
    {
        $this->s3UploadClient = new S3Client([
            'version'                 => 'latest',
            'region'                  => 'us-east-1',
            'endpoint'                => config('filesystem.disks.minio.endpoint'),
            'use_path_style_endpoint' => true,
            'credentials'             => [
                'key'    => config('filesystem.disks.minio.accessId'),
                'secret' => config('filesystem.disks.minio.accessSecret'),
            ],
        ]);
        $this->bucketName     = config('filesystem.disks.minio.bucket');
    }

    /**
     * 执行上传
     * @param $sourceFile
     * @param string $sourceName
     * @param string $type
     * @return bool|mixed
     * @throws \Exception
     */

    public function upload($sourceFile, $sourceName = '', $type = 'image/jpeg')
    {

        try {
            //$module, $sourceFilePath, $originName, $acl = self::ACL_PUBLIC_READ
            // 要上传图片的本地路径
            $uploadFilePath = date('Y-m') . '/' . $sourceName;
            $result         = $this->s3UploadClient->putObject([
                'Bucket'      => $this->bucketName,
                'Key'         => $uploadFilePath,
                'SourceFile'  => $sourceFile,
                'ACL'         => self::ACL_PUBLIC_READ,
                'ContentType' => $type
            ]);

            return [
                'path'      => $this->bucketName . '/' . $uploadFilePath,
                'full_path' => $result->get('ObjectURL'),
            ];
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function getEndpoint()
    {
        return rtrim($this->s3UploadClient->getEndpoint(), '/') . '/';
    }

    public function objectExist($path)
    {
        return $this->s3UploadClient->doesObjectExist($this->bucketName, trim($path, $this->bucketName));
    }

    public function getObjectUrl($path)
    {
        return $this->s3UploadClient->getObjectUrl($this->bucketName, trim(trim($path, $this->bucketName),'/'));
    }

}