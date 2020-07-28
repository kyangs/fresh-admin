<?php


namespace app\repository\user;


use app\traits\RepositoryTrait;

class UserRepository
{
    //模型，带命名空间
    public static $model = 'app\model\User';
    //模型主键
    public static $pk = 'id';
    public static $showField = ['*'];
    use RepositoryTrait;
}
