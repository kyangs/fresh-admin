<?php
declare (strict_types=1);

namespace app\controller\api\adv;

use app\controller\api\Base;
use app\service\AdvService;
use app\service\home\HomeService;
use think\annotation\route\Group;
use think\annotation\Route;

/**
 * 非用户身份类接口
 * Class Adv
 * @package app\controller\api\adv
 * @author  kyangs@163.com
 * @Group("api/adv")
 */
class Adv extends Base
{
    /**
     * @Route("list", method="GET")
     */
    public function advList()
    {
        try {
            return json_ok(AdvService::advListByPosition($this->request->get()));
        } catch (\Exception $exception) {
            return json_error(10001, $exception->getMessage());
        }
    }
}
