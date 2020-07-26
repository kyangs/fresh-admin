<?php
declare (strict_types=1);

namespace app\repository\file;

use app\model\common\SystemSetting;
use app\traits\RepositoryTrait;
use Aws\S3\S3Client;

/**
 * 管理员
 * Class FileRepository
 * @package app\repository\file
 * @author  kyangs@163.com
 */
class MinioFileRepository extends FileRepository
{

    private $s3UploadClient;
    private $bucketName;
    protected $setting;

    public function __construct($setting)
    {
        if (empty($this->s3UploadClient)) {

            $this->s3UploadClient = new S3Client([
                'version'                 => 'latest',
                'region'                  => 'us-east-1',
                'endpoint'                => $setting['endpoint'],
                'use_path_style_endpoint' => true,
                'credentials'             => [
                    'key'    => $setting['userName'],
                    'secret' => $setting['password'],
                ],
            ]);
            $this->bucketName     = $setting['bucket'];
        }
        $this->setting = $setting;
    }


    public function upload($sourceFile, $sourceName = '', $type = 'image/jpeg')
    {
        try {
            $uploadFilePath = date('Y-m') . '/' . $sourceName;
            $result         = $this->s3UploadClient->putObject([
                'Bucket'      => $this->bucketName,
                'Key'         => $uploadFilePath,
                'SourceFile'  => $sourceFile,
                'ACL'         => 'public-read',
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

}
