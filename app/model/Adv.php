<?php
declare (strict_types=1);

namespace app\model;

use app\service\UploadService;
use think\Model;
use app\traits\ModelTrait;

/**
 * 管理员
 * Class Adv
 * @package app\model
 */
class Adv extends Model
{
    use ModelTrait;

    public static $position = [
        'home'        => '首页',
        'detail'      => '商品详情页',
        'center'      => '个人中心页',
        'cart'        => '购物车页',
        'home_notice' => '首页公告位置',
    ];

    public function findAbleAdv($time, $position = ['home', 'home_notice'])
    {
        $data = [];
        foreach ($this->where('start_time', '<=', $time)
                     ->where('end_time', '>=', $time)
                     ->where(['position' => $position])
                     ->where(['is_enabled' => 1])
                     ->order('sort','asc')
                     ->select() as $item) {
            $item['full_path']         = UploadService::fullPath($item['image']);
            $data[$item['position']][] = $item;
        }
        return $data;
    }
}



