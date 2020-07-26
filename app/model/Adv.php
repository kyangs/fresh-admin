<?php
declare (strict_types=1);

namespace app\model;

use app\model\common\File;
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
        return $this->where('start_time', '<=', $time)
            ->where('end_time', '>=', $time)
            ->where(['position' => $position])
            ->where(['is_enabled' => 1])
            ->order('sort', 'asc')
            ->select()
            ->toArray();
    }


    /** 通过条件搜索
     * @param $request
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function listByFilter($request)
    {
        $_this = $this;
        if (!empty($request->position)) {
            $_this = $_this->where('position', '=', $request->position);
        }
        if (!empty($request->time_range)) {
            list($start, $end) = $request->time_range;
            $_this = $_this->where('start_time', '>=', $start);
            $_this = $_this->where('end_time', '<=', $end);
        }
        if (!empty($request->username)) {
            $_this = $_this->where('username', 'like', '%' . $request->username . '%');
        }
        return $_this->select()->toArray();
    }


    /** 启用禁用
     * @param $id
     * @param $status
     * @return string
     */
    public function enable($id, $status)
    {
        $isEnabled = intval($status) == 1 ? '0' : '1';
        self::update(['is_enabled' => $isEnabled], ['id' => $id]);
        return $isEnabled;
    }
}



