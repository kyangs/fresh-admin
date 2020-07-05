<?php


namespace app\service\home;


use app\model\Adv;
use app\service\BaseService;

class HomeService extends BaseService
{

    /**
     *
     */
    public function home(){
        $adv = (new Adv)->findAbleAdv($this->time());
        return $adv;
    }
}