<?php
namespace app\admin\controller;

use think\Controller;
use think\facade\Session;

class Base extends Controller
{
    protected $validate;

    protected $model;

    protected $user;

    protected function initialize()
    {
        $action = $this->request->action();
        $controller = $this->request->controller();

        // 判断是否需要登录验证
        if(!in_array($action, ['captcha', 'login', 'index'])){

            if(!Session::has('user', 'admin')){
                return $this->result('', 1001, '');
            }

            $this->user = Session::get('user', 'admin');

        }

        // 判断当前控制器是否需要实例化validate和model类
        if(!in_array($controller, ['Index'])){
            $this->validate = validate($controller);
            $this->model = model($controller);
        }
    }
}