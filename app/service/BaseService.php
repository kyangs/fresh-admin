<?php
declare (strict_types=1);

namespace app\service;


use app\model\Adv;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

/**
 * 管理员
 * Class BaseService
 * @package app\service
 * @author  kyangs@163.com
 */
class BaseService
{

    public function time()
    {
        return date('Y-m-d H:i:s');
    }
}
