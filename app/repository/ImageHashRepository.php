<?php
declare (strict_types=1);
namespace app\repository;

use app\traits\RepositoryTrait;

/**
 * 图片hash
 * Class ImageHashRepository
 * @package app\repository
 * @author  kyangs@163.com
 */
class ImageHashRepository
{

    //模型，带命名空间
    public static $model = 'app\model\ImageHash';
    //模型主键
    public static $pk = 'id';
    //name字段名称
    public static $name = 'hash';

    use RepositoryTrait;

}
