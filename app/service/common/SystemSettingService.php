<?php


namespace app\service\common;


use app\model\common\Category;
use app\model\common\File;
use app\model\common\FileGroup;
use app\repository\system\SystemSettingRepository;
use app\service\BaseService;
use app\service\UploadService;

class SystemSettingService extends BaseService
{

    public static function saveSetting($request, $key)
    {
        return SystemSettingRepository::saveSetting($key, $request, '上传设置');
    }

    public static function setting($key)
    {
        return SystemSettingRepository::setting($key);
    }
}
