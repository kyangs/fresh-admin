<?php
declare (strict_types=1);
namespace app\service;

use app\traits\ServiceTrait;

/**
 * 文章
 * Class ArticleService
 * @package app\service
 * @author  kyangs@163.com
 */
class ArticleService
{
    //仓库，带命名空间
    public static $repository = 'app\repository\ArticleRepository';

    use ServiceTrait;

}
