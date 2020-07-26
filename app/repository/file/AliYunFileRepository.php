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


            return [
                'path'      => '',
                'full_path' => '',
            ];
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
