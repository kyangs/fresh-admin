<?php
declare (strict_types=1);
namespace app\repository;

use app\traits\RepositoryTrait;

/**
 * 管理员登陆日志
 * Class LoginLogRepository
 * @package app\repository
 * @author  kyangs@163.com
 */
class LoginLogRepository
{
    //模型，带命名空间
    public static $model = 'app\model\LoginLog';
    //模型主键
    public static $pk = 'id';
    //name字段名称
    public static $name = 'uid';

    use RepositoryTrait;

}
