<?php
declare (strict_types=1);

namespace app\service;

use app\traits\ServiceTrait;

/**
 *图片hash
 * Class ImageHashService
 * @package app\service
 * @author  kyangs@163.com
 */
class ImageHashService
{
    //仓库，带命名空间
    public static $repository = 'app\repository\ImageHashRepository';

    use ServiceTrait;

}
