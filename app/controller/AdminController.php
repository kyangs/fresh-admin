<?php
declare (strict_types=1);

namespace app\controller;

use app\BaseController;
use app\model\Admin;
use app\service\AdminService;
use app\util\JwtUtil;
use think\facade\Log;

/**
 * 管理端基类
 * Class AdminController
 * @package app\controller
 * @author  kyangs@163.com
 */
class AdminController extends BaseController
{
    //用户信息
    protected $user = null;

    // 初始化
    protected function initialize()
    {
        //dd($this->app->request->header('x-access-token'));
        try {

            Log::debug($this->app->request->post());
            $obj        = JwtUtil::decode(think_decrypt($this->app->request->header('x-access-token')));
            $this->user = AdminService::getInfoById($obj->aid);
        } catch (\Exception $exception) {

        }
    }

}
