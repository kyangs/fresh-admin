<?php
declare (strict_types=1);
namespace app\service;

use app\traits\ServiceTrait;

/**
 * 应用
 * Class AppService
 * @package app\service
 * @author  kyangs@163.com
 */
class AppService
{
    //仓库，带命名空间
    public static $repository = 'app\repository\AppRepository';

    use ServiceTrait;

}
