<?php
declare (strict_types=1);
namespace app\service;

use app\traits\ServiceTrait;

/**
 * 文章栏目
 * Class ArticleColumnService
 * @package app\service
 * @author  kyangs@163.com
 */
class ArticleColumnService
{
    //仓库，带命名空间
    public static $repository = 'app\repository\ArticleColumnRepository';

    use ServiceTrait;

}
