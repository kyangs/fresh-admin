<?php
declare (strict_types=1);
namespace app\repository;

use app\traits\RepositoryTrait;

/**
 * 权限
 * Class AuthRuleRepository
 * @package app\repository
 * @author  kyangs@163.com
 */
class AuthRuleRepository
{

    //模型，带命名空间
    public static $model = 'app\model\AuthRule';
    //模型主键
    public static $pk = 'id';
    //name字段名称
    public static $name = '';

    use RepositoryTrait;

}
