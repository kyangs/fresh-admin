<?php
declare (strict_types=1);

namespace app\validate;

use think\Validate;

/**
 * 用户
 * Class User
 * @package app\validate
 * @author  kyangs@163.com
 * @date 2019-11-27
 */
class UserValidate extends Validate
{
    //验证规则 unique:table,field,except,pk
    protected $rule = [
        'nickname' => ['require'],
        'account'  => ['require', 'regex' => '/[a-zA-Z\d]{4,16}/', 'unique' => 'user,account'],
        'phone'    => ['regex' => '/1\d{10}$/', 'unique' => 'user,phone'],
    ];

    //提示信息
    protected $message = [
        'nickname.require' => '请填写昵称',
        'phone.regex'      => '手机格式错误',
        'account.regex'    => '登录账号为长度在4到16个4-16纯字母，纯数字或字母与数字组合',
        'account.unique'   => '登录账号已存在',
        'phone.unique'     => '手机号已注册',
    ];

    //验证场景
    protected $scene = [
    ];


}
