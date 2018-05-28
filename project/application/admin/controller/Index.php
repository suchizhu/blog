<?php
namespace app\admin\controller;

use think\captcha\Captcha;

class Index extends Base
{
    public function index()
    {
        return $this->fetch();
    }

    public function captcha()
    {
        $config = [
            'useCurve' => false,
            'useNoise' => false,
            'bg'       => [255, 255, 255],
            'fontttf'  => '1.ttf'
        ];

        $captcha = new Captcha($config);
        return $captcha->entry();
    }

    public function menu()
    {
        $data = [[
            'title' => '主页',
            'icon'  => 'layui-icon-home',
            'list'  => [[
                'title' => '控制台',
                'jump'  => '/'
            ]]
        ],[
            'name'  => 'content',
            'title' => '内容管理',
            'icon'  => 'layui-icon-component',
            'list'  => [[
                'name'  => 'article',
                'title' => '文章管理',
                'list'  => [[
                    'name'  => 'list',
                    'title' => '文章列表'
                ],[
                    'name'  => 'del',
                    'title' => '文章删除列表'
                ]]
            ],[
                'name'  => 'articleType',
                'title' => '文章类型管理',
                'list'  => [[
                    'name'  => 'list',
                    'title' => '文章类型列表'
                ],[
                    'name'  => 'del',
                    'title' => '文章类型删除列表'
                ]]
            ],[
                'name'  => 'comment',
                'title' => '评论管理',
                'list'  => [[
                    'name'  => 'list',
                    'title' => '评论列表'
                ],[
                    'name'  => 'del',
                    'title' => '评论删除列表'
                ]]
            ],[
                'name'  => 'link',
                'title' => '友情链接管理',
                'list'  => [[
                    'name'  => 'list',
                    'title' => '友情链接列表'
                ],[
                    'name'  => 'del',
                    'title' => '友情链接删除列表'
                ]]
            ],[
                'name'  => 'product',
                'title' => '产品管理',
                'list'  => [[
                    'name'  => 'list',
                    'title' => '产品列表'
                ],[
                    'name'  => 'del',
                    'title' => '产品删除列表'
                ]]
            ],[
                'name'  => 'image',
                'title' => '图片管理',
                'list'  => [[
                    'name'  => 'uploadAvatar',
                    'title' => '默认头像上传'
                ]]
            ]]
        ],[
            'name'  => 'user',
            'title' => '用户',
            'icon'  => 'layui-icon-user',
            'list'  => [[
                'name'  => 'user',
                'title' => '用户管理',
                'list'  => [[
                    'name'  => 'list',
                    'title' => '用户列表'
                ],[
                    'name'  => 'del',
                    'title' => '用户删除列表'
                ]]
            ],[
                'name'  => 'role',
                'title' => '角色管理',
                'list'  => [[
                    'name'  => 'list',
                    'title' => '角色列表'
                ],[
                    'name'  => 'del',
                    'title' => '角色删除列表'
                ]]
            ],[
                'name'  => 'access',
                'title' => '权限管理',
                'list'  => [[
                    'name'  => 'list',
                    'title' => '权限列表'
                ],[
                    'name'  => 'del',
                    'title' => '权限删除列表'
                ]]
            ]]
        ],[
            'name'  => 'set',
            'title' => '设置',
            'icon'  => 'layui-icon-set',
            'list'  => [[
                'name'  => 'system',
                'title' => '系统设置',
                'list'  => [[
                    'name'  => 'website',
                    'title' => '网站设置'
                ]]
            ],[
                'name'  => 'user',
                'title' => '我的设置',
                'list'  => [[
                    'name'  => 'info',
                    'title' => '基本资料设置'
                ],[
                    'name'  => 'password',
                    'title' => '密码设置'
                ]]
            ]]
        ],[
            'name'  => 'log',
            'title' => '日志',
            'icon'  => 'layui-icon-chat',
            'list'  => [[
                'name'  => 'login',
                'title' => '登录日志'
            ],[
                'name'  => 'operat',
                'title' => '操作日志'
            ]]
        ]];
        return $this->result($data, 0, '');
    }
}