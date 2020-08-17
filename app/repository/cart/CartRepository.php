<?php
declare (strict_types=1);

namespace app\repository\cart;

use app\model\common\SystemSetting;
use app\repository\file\FileSystemRepository;
use app\traits\RepositoryTrait;

/**
 * 管理员
 * Class AdminRepository
 * @package app\repository\system
 * @author  kyangs@163.com
 */
class CartRepository
{
    //模型，带命名空间
    public static $model = 'app\model\cart\Cart';
    //模型主键
    public static $pk        = 'id';
    public static $showField = ['*'];

    use RepositoryTrait;

}
