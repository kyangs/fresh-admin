<?php
declare (strict_types=1);
namespace app\repository\goods;

use app\traits\RepositoryTrait;

/**
 * 应用
 * Class GoodsRepository
 * @package app\repository\goods
 * @author  kyangs@163.com
 */
class GoodsRepository
{

    //模型，带命名空间
    public static $model = 'app\model\Goods';
    //模型主键
    public static $pk = 'id';
    //name字段名称
    public static $name = 'appid';

    use RepositoryTrait;

}
