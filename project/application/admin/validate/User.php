<?php
namespace app\admin\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        'username'    => 'require|regex:/^[\S]{5,15}$/',
        'password'    => 'require|regex:/^[\S]{6,15}$/',
        'oldPassword' => 'require',
        'newPassword' => 'require|regex:/^[\S]{6,15}$/',
        'rePassword'  => 'confirm:newPassword',
        'nickname'    => 'require|max:30',
        'captcha'     => 'require',
        'id'          => 'require|number|egt:1',
        'role_id'     => 'require|number|egt:1'
    ];

    protected $field = [
        'username'    => '用户名',
        'password'    => '密码',
        'oldPassword' => '当前密码',
        'newPassword' => '新密码',
        'nickname'    => '昵称',
        'captcha'     => '验证码',
        'role_id'     => '角色'
    ];

    protected $message = [
        'username.regex'     => '用户名必须5-15位,且不能有空格',
        'password.regex'     => '密码必须6-15位,且不能有空格',
        'newPassword.regex'  => '新密码必须6-15位,且不能有空格',
        'rePassword.confirm' => '两次密码输入不一致'
    ];

    protected $scene = [
        'login'    => ['username', 'password', 'captcha'],
        'info'     => ['username', 'nickname'],
        'password' => ['oldPassword', 'newPassword', 'rePassword'],
        'status'   => ['id','status'],
        'add'      => ['username','password','nickname','role_id']
    ];
}