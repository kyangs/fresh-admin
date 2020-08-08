<?php


namespace app\service\home;


use app\model\Adv;
use app\repository\adv\AdvRepository;
use app\repository\file\FileSystemRepository;
use app\service\BaseService;
use app\service\common\CategoryService;
use app\service\common\NoticeService;
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
            'adv_list'      => AdvRepository::findAbleAdv(self::time()),
            'category_list' => CategoryService::showHomeAndEnable(),
            'notice_list'   => NoticeService::enableList(),
        ];
    }
}
