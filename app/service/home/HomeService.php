<?php


namespace app\service\home;


use app\model\Adv;
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
        $data      = [];
        $advList   = (new Adv)->findAbleAdv(self::time());
        $imageList = FileSystemRepository::findByIds(array_column($advList, 'image_id'),true);
        foreach ($advList as $item) {
            $item['full_path'] = '';
            if (isset($imageList[$item['image_id']])) {
                $item['full_path'] = $imageList[$item['image_id']];
            }
            $data[$item['position']][] = $item;
        }
        return [
            'adv_list'      => $data,
            'category_list' => CategoryService::showHomeAndEnable(),
            'notice_list'   => NoticeService::enableList(),
        ];
    }
}
