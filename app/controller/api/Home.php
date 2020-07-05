<?php
declare (strict_types=1);

namespace app\controller\api;

use app\controller\api\Base;
use app\service\home\HomeService;
use think\annotation\route\Group;
use think\annotation\Route;

/**
 * 非用户身份类接口
 * Class Home
 * @package app\controller\api
 * @author  kyangs@163.com
 * @Group("api/home")
 */
class Home extends Base
{
    /**
     * @Route("index", method="GET")
     */
    public function index()
    {
        try {
            $HomeService = new HomeService;
            return json_ok($HomeService->home($this->params));
        } catch (\Exception $exception) {
            return json_error(10001, $exception->getMessage());
        }
    }
}
