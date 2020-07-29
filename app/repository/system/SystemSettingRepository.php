<?php
declare (strict_types=1);

namespace app\repository\system;

use app\model\common\SystemSetting;
use app\repository\file\FileSystemRepository;
use app\traits\RepositoryTrait;

/**
 * 管理员
 * Class AdminRepository
 * @package app\repository\system
 * @author  kyangs@163.com
 */
class SystemSettingRepository
{
    //模型，带命名空间
    public static $model = 'app\model\common\SystemSetting';
    //模型主键
    public static $pk = 'unique_key';
    public static $showField = ['*'];

    use RepositoryTrait;

    public static function saveSetting($key, $value, $describe = '')
    {
        return SystemSetting::saveSetting($key, $value, $describe);
    }


    public static function setting($key)
    {
        $setting = SystemSetting::getSettingByKey($key);
        if (!empty($setting)) {

            return json_decode($setting['value'], true);
        }
        return [];
    }

    public static function fullPath($path, $configKey)
    {
        $settingMapping = SystemSetting::uploadSettingMapping();
        $setting        = [];
        if (isset($settingMapping[$configKey])) {
            $setting = $settingMapping[$configKey];
        }
        return SystemSetting::fullUploadUrl($setting) . $path;
    }
}
