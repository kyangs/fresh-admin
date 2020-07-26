<?php
declare (strict_types=1);

namespace app\repository\file;

use app\model\common\File;
use app\model\common\SystemSetting;

/**
 * 管理员
 * Class FileSystemRepository
 * @package app\repository\file
 * @author  kyangs@163.com
 */
class FileSystemRepository
{
    protected $setting;

    /**
     * @param $setting
     * @return string
     */

    public static function fullUrl($setting)
    {
        return rtrim($setting['endpoint'], '/') . '/';
    }

    /**
     * @param $filter
     * @return array
     * @throws \think\db\exception\DbException
     */
    public static function listByFilter($filter)
    {
        $_this = (new File());
        if (isset($filter->id)) {
            $_this = $_this->where(['group_id' => $filter->id]);
        }
        $page       = $_this->where(['is_delete' => '0'])
            ->order('id', 'desc')
            ->paginate($filter->pageSize)
            ->toArray();
        $httpPrefix = self::fullUrl(SystemSetting::defaultUploadSetting());
        foreach ($page['data'] as &$item) {
            $item['file_size'] = round($item['file_size'] / 1024, 2) . 'KB';
            $item['full_url']  = $httpPrefix . $item['file_url'];
        }
        return $page;
    }

    /** 文件列表 以id 为key
     * @param $imageIds
     * @param bool $onlyUrl
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function findByIds($imageIds, $onlyUrl = false)
    {
        $imgList = [];
        if (empty($imageIds)) return $imgList;
        $httpPrefix = self::fullUrl(SystemSetting::defaultUploadSetting());
        foreach (File::where(['id' => $imageIds])->select()->toArray() as &$item) {
            $item['full_url']     = $httpPrefix . $item['file_url'];
            $imgList[$item['id']] = $onlyUrl ? $item['full_url'] : $item;
        }
        return $imgList;
    }


    public static function findById($imageIds, $onlyUrl = true)
    {
        if (empty($imageIds)) return '';

        $httpPrefix      = self::fullUrl(SystemSetting::defaultUploadSetting());
        $row             = File::where(['id' => $imageIds])->find()->toArray();
        $row['full_url'] = $httpPrefix . $row['file_url'];
        return $onlyUrl ? $row['full_url'] : $row;
    }
}
