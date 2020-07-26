<?php


namespace app\service;


use app\model\common\SystemSetting;
use app\repository\file\AliYunFileRepository;
use app\repository\file\FileSystemRepository;
use app\repository\file\MinioFileRepository;
use app\repository\file\QiniuFileRepository;
use app\repository\file\TxYunFileRepository;
use app\repository\system\SystemSettingRepository;

class UploadService
{

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
            $setting = SystemSettingRepository::setting('upload');
            if (empty($setting)) throw new \Exception('请先配置上传设置', 1);
            $data = [];
            switch ($setting['default']) {
                case 'aliyun':
                    $data = (new AliYunFileRepository($setting['aliyun']))->upload($sourceFile, $sourceName, $type);
                    break;
                case 'qiniuyun':
                    $data = (new QiniuFileRepository($setting['qiniuyun']))->upload($sourceFile, $sourceName, $type);
                    break;
                case 'txyun':
                    $data = (new TxYunFileRepository($setting['txyun']))->upload($sourceFile, $sourceName, $type);
                    break;
                case 'minio':
                    $data = (new MinioFileRepository($setting['minio']))->upload($sourceFile, $sourceName, $type);
                    break;
            }
            return $data;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function fullPath($path)
    {
        return FileSystemRepository::fullUrl(SystemSetting::defaultUploadSetting()) . $path;
    }
}