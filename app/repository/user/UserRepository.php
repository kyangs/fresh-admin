<?php


namespace app\repository\user;


use app\model\common\SystemSetting;
use app\repository\system\SystemSettingRepository;
use app\traits\RepositoryTrait;

class UserRepository
{

    const LOGIN_MODE_MODE = 'PASS'; // 密码登录
    const LOGIN_MODE_SMS = 'SMS'; // 手机验证码登录
    //模型，带命名空间
    public static $model = 'app\model\User';
    //模型主键
    public static $pk = 'id';
    public static $showField = ['*'];
    use RepositoryTrait;
}
