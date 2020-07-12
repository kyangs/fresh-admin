<?php


namespace app\service\home;


use app\model\Adv;
use app\service\BaseService;
use app\service\common\CategoryService;
use utils\Utils;

class HomeService extends BaseService
{


    /**
     * @param $request
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function home($request)
    {
        return [
            'adv_list'         => (new Adv)->findAbleAdv($this->time()),
            'category_list'    => CategoryService::showHomeAndEnable(),
        ];
    }
}