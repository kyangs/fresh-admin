<?php
declare (strict_types=1);

namespace app\repository\system;

use app\model\common\SystemSetting;
use app\traits\RepositoryTrait;

/**
 * 管理员
 * Class AdminRepository
 * @package app\repository\system
 * @author  kyangs@163.com
 */
class SystemSettingRepository
{
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
}
