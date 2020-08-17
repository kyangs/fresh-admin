<?php
declare (strict_types=1);

namespace app\cart;

use app\model\Admin as AdminModel;
use app\service\BaseService;
use app\traits\ServiceTrait;
use app\util\JwtUtil;
use app\service\AuthGroupService;

/**
 * 管理员
 * Class AdminService
 * @package app\service
 * @author  kyangs@163.com
 */
class CartService extends BaseService
{
    use ServiceTrait;

    public static function addCart($post){
dd($post);
    }
}
