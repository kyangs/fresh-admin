<?php


namespace app\controller\api\location;


use app\controller\api\Base;
use app\service\common\LocationService;
use think\annotation\route\Group;
use think\annotation\Route;

/**
 * 非用户身份类接口
 * Class Location
 * @package app\controller\api
 * @author  kyangs@163.com
 * @Group("api/location")
 */
class Location extends Base
{

    /**
     * @Route("location", method="POST")
     */
    public function location()
    {
        try {
            return json_ok(LocationService::location($this->params));
        } catch (\Exception $exception) {
            return json_error(10001, $exception->getMessage());
        }
    }
}