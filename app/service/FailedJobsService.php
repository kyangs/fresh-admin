<?php
declare (strict_types=1);

namespace app\service;

use app\traits\ServiceTrait;

/**
 * 失败队列服务
 * Class FailedJobsService
 * @package app\service
 * @author  kyangs@163.com
 */
class FailedJobsService
{
    //仓库，带命名空间
    public static $repository = 'app\repository\FailedJobsRepository';

    use ServiceTrait;
}
