<?php


namespace app\service\home;


use app\model\Adv;
use app\service\BaseService;
use app\service\common\CategoryService;

class HomeService extends BaseService
{

    /**
     *
     */
    public function home()
    {
        return [
            'adv_list'      => (new Adv)->findAbleAdv($this->time()),
            'category_list' => CategoryService::showHomeAndEnable(),
        ];
    }
}