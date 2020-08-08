<?php


namespace app\repository\adv;


use app\model\Adv;
use app\model\common\SystemSetting;
use app\repository\file\FileSystemRepository;
use app\repository\system\SystemSettingRepository;
use app\traits\RepositoryTrait;

class AdvRepository
{
    //模型，带命名空间
    public static $model = 'app\model\Adv';
    //模型主键
    public static $pk        = 'id';
    public static $showField = ['*'];
    use RepositoryTrait;

    /**
     * @param $time
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function findAbleAdv($time, $position = [])
    {
        $advList   = (new Adv)->findAbleAdv($time,$position);
        $imageList = FileSystemRepository::findByIds(array_column($advList, 'image_id'), true);
        foreach ($advList as $item) {
            $item['full_path'] = '';
            if (isset($imageList[$item['image_id']])) {
                $item['full_path'] = $imageList[$item['image_id']];
            }
            $data[$item['position']][] = $item;
        }
        return $data;
    }
}
