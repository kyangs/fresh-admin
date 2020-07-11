<?php


namespace app\controller\api\category;

use app\service\common\CategoryService;
use think\annotation\route\Group;
use think\annotation\Route;
use app\controller\api\Base;

/**
 * 非用户身份类接口
 * Class Home
 * @package app\controller\api
 * @author  kyangs@163.com
 * @Group("api/category")
 */
class Category extends Base
{

    /**
     * @Route("list", method="GET")
     */
    public function categoryList()
    {
        try {
            return json_ok([
                'category_list' => CategoryService::categoryList($this->params),
            ]);
        } catch (\Exception $exception) {
            return json_error(10001, $exception->getMessage());
        }
    }
}