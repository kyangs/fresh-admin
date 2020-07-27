<?php
declare (strict_types=1);

namespace app\repository\file;

use app\model\common\SystemSetting;
use app\traits\RepositoryTrait;
use Aws\S3\S3Client;
use OSS\OssClient;

/**
 * 管理员
 * Class FileRepository
 * @package app\repository\file
 * @author  kyangs@163.com
 */
class AliYunFileRepository extends FileRepository
{

    protected $setting;

    public function __construct($setting)
    {
        $this->setting = $setting;
    }


    public function upload($sourceFile, $sourceName = '', $type = 'image/jpeg')
    {
        try {

            $ossClient = new OssClient($this->setting['accessKeyId'], $this->setting['accessKeySecret'], $this->setting['endpoint']);

            $res = $ossClient->uploadFile($this->setting['bucket'], $sourceName, $sourceFile);

            $data = $res['info'];

            return [
                'path'      => $sourceName,
                'full_path' => $data['url'],
            ];
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
