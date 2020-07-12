<?php
declare (strict_types=1);

namespace app\controller\admin;

use app\controller\admin\Base;
use app\service\AuthGroupService;
use app\service\AuthRuleService;
use app\service\common\NoticeService;
use app\traits\ControllerTrait;
use think\annotation\route\Middleware;
use think\annotation\route\Group;
use think\annotation\Route;
use app\middleware\CheckAdmin;
use app\util\TreeUtil;

/**
 * 管理员管理
 * Class Notice
 * @package app\controller\admin
 * @author  kyangs@163.com
 * @Group("admin/notice")
 * @Middleware({CheckAdmin::class})
 */
class Notice extends Base
{
    use ControllerTrait;

    /**
     * 获取登录用户信息
     * @Route("list", method="POST")
     * @throws \Exception
     */
    public function getList()
    {
        return json_ok(NoticeService::listByFilter($this->params));
    }

    /**
     * 获取登录用户信息
     * @Route("enable", method="POST")
     * @throws \Exception
     */
    public function enable()
    {
        return json_ok(NoticeService::enable($this->params));
    }

    /**
     * 获取登录用户信息
     * @Route("param", method="POST")
     */
    public function param()
    {
        return json_ok([
            'position' => [],
        ]);
    }

    /**
     * 获取登录用户信息
     * @Route("notice", method="POST")
     */
    public function saveNotice()
    {
        try {
            NoticeService::saveNotice($this->params, $this->user);
            return json_ok();
        } catch (\Exception $exception) {
            return json_error(10001, $exception->getMessage());
        }
    }

    /**
     * 删除信息
     * @Route("delete", method="POST")
     */
    public function deleteNotice()
    {
        try {
            NoticeService::deleteNotice($this->params);
            return json_ok();
        } catch (\Exception $exception) {
            return json_error(10001, $exception->getMessage());
        }
    }
}
