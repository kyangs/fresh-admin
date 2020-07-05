<?php
declare (strict_types=1);
namespace app\repository;

use app\traits\RepositoryTrait;

/**
 * 应用
 * Class AppRepository
 * @package app\repository
 * @author  kyangs@163.com
 */
class AppRepository
{

    //模型，带命名空间
    public static $model = 'app\model\App';
    //模型主键
    public static $pk = 'id';
    //name字段名称
    public static $name = 'appid';

    use RepositoryTrait;

}
