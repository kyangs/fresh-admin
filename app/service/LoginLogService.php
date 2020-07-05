<?php
declare (strict_types=1);

namespace app\service;

use app\traits\ServiceTrait;

/**
 * 管理员登录日志
 * Class LoginLogService
 * @package app\service
* @author  kyangs@163.com
*/
class LoginLogService
{
    //仓库，带命名空间
    public static $repository = 'app\repository\LoginLogRepository';

    use ServiceTrait;

}
