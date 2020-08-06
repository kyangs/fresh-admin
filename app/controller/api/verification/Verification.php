<?php


namespace app\controller\api\verification;


use app\controller\api\Base;
use app\service\common\VerificationService;
use think\annotation\route\Group;
use think\annotation\Route;
use think\helper\Str;

/**
 * 非用户身份类接口
 * Class Verification
 * @package app\controller\api\verification
 * @author  kyangs@163.com
 * @Group("api/verification")
 */
class Verification extends Base
{

    /**
     * @Route("code", method="POST")
     */
    public function code()
    {
        try {
            return json_ok(VerificationService::sendVerificationCode($this->request->post()));
        } catch (\Exception $exception) {
            return json_error(10001, $exception->getCode() == 1 ? $exception->getMessage() : '发送失败');
        }
    }
}
