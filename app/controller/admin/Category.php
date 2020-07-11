<?php
declare (strict_types=1);

namespace app\controller\admin;

use app\controller\admin\Base;
use app\service\AdvService;
use app\service\AuthGroupService;
use app\service\AuthRuleService;
use app\service\common\CategoryService;
use app\traits\ControllerTrait;
use think\annotation\route\Middleware;
use think\annotation\route\Group;
use think\annotation\Route;
use app\middleware\CheckAdmin;
use app\util\TreeUtil;
use app\model\Adv as AdvModel;

/**
 * 管理员管理
 * Class Category
 * @package app\controller\admin
 * @author  kyangs@163.com
 * @Group("admin/category")
 * @Middleware({CheckAdmin::class})
 */
class Category extends Base
{
    use ControllerTrait;

    /**
     * 获取登录用户信息
     * @Route("list", method="POST")
     * @throws \Exception
     */
    public function getlist()
    {
        return json_ok((new CategoryService)->listByFilter($this->params));
    }

    /**
     * 获取登录用户信息
     * @Route("enable", method="POST")
     * @throws \Exception
     */
    public function enable()
    {
        return json_ok(CategoryService::enable($this->params));
    }

    /**
     * 获取登录用户信息
     * @Route("parent", method="POST")
     * @throws \Exception
     */
    public function parentCategory()
    {
        return json_ok([
            'parent_category' => CategoryService::parentCategory(),
        ]);
    }

    /**
     * 获取登录用户信息
     * @Route("category", method="POST")
     */
    public function saveCategory()
    {
        try {
            CategoryService::saveCategory($this->params, $this->user);
            return json_ok();
        } catch (\Exception $exception) {
            return json_error(10001, $exception->getMessage());
        }
    }

    /**
     * 删除信息
     * @Route("delete", method="POST")
     */
    public function deleteCategory()
    {
        try {
            CategoryService::deleteCategory($this->params);
            return json_ok();
        } catch (\Exception $exception) {
            return json_error(10001, $exception->getMessage());
        }
    }
}
