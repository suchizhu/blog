<?php
namespace app\admin\controller;

use think\facade\Session;

class User extends Base
{
    // 登录验证
    public function login()
    {
        // 获取登录提交数据并验证
        $data = $this->request->post();
        if (!$this->validate->scene('login')->check($data)) {
            return $this->result('', 1, $this->validate->getError());
        }
        if (!captcha_check($data['captcha'])) {
            return $this->result('', 1, '验证码输入错误');
        };
        $user = $this->model->get(['username' => $data['username']]);
        if (!$user) {
            return $this->result('', 1, '用户不存在');
        }
        if ($user['password'] != md5($data['password'])) {
            return $this->result('', 1, '密码输入错误');
        }
        if ($user['role_id'] == 0) {
            return $this->result('', 1, '此用户没有权限登录');
        }

        // 生成token并使用session保存用户登录信息
        $token = md5($data['username']);
        $user['token'] = $token;
        Session::set('user', $user, 'admin');
        return $this->result(['access_token' => $token], 0, '登入成功');
    }

    // 获取登录用户数据
    public function session()
    {
        $data = [
            'username' => $this->user['nickname']
        ];
        return $this->result($data, 0, '');
    }

    // 退出登录
    public function logout()
    {
        Session::delete('user', 'admin');
        return $this->result(null, 0, '');
    }

    /**
     * @GET 返回当前登录用户基本资料数据
     * @POST 用户基本资料修改功能
     */
    public function info()
    {
        if ($this->request->isPost()) {

            // 获取数据并验证
            $data = $this->request->post();
            if(!$this->validate->scene('info')->check($data)){
                return $this->result('', 1, $this->validate->getError());
            }

            // 判断用户名或昵称是否存在
            $this->isRepeat('username', $data, '用户名已存在');
            $this->isRepeat('nickname', $data, '昵称已存在');

            try{
                $this->model->allowField(['username','nickname'])->save($data,['id'=>$this->user['id']]);
            }catch(\Exception $e){
                return $this->result('', 1, '修改异常');
            }

            // 重置session保存数据
            $user = $this->model->get(['id'=>$this->user['id']]);
            $user['token'] = $this->user['token'];
            Session::set('user', $user, 'admin');

            return $this->result('', 0, '基本资料修改成功');
        } else {
            $this->user['role'] = model('role')->where('id', $this->user['role_id'])->value('name');
            $this->user['avatar'] = model('image')->where('id', $this->user['image_id'])->value('src');
            return $this->result($this->user, 0, '');
        }
    }

    // 判断字段值是否重复
    public function isRepeat($field, $data, $msg)
    {
        $user = $this->model->get([$field=>$data[$field]]);
        if($user && $user['id'] != $this->user['id']){
            return $this->result('', 1, $msg);
        }
    }

    // 密码修改
    public function password()
    {
        // 获取数据并验证
        $data = $this->request->post();
        if(!$this->validate->scene('password')->check($data)){
            return $this->result('', 1, $this->validate->getError());
        }
        if($this->user['password'] != md5($data['oldPassword'])){
            return $this->result('', 1, '当前密码输入错误');
        }

        // 密码加密并更改
        $data['password'] = md5($data['newPassword']);
        try{
            $this->model->allowField(['password'])->save($data,['id'=>$this->user['id']]);
        }catch(\Exception $e){
            return $this->result('', 1, '密码修改异常');
        }

        // 注销当前登录用户信息
        Session::delete('user', 'admin');
        return $this->result('', 0, '密码修改成功,请重新登录');
    }
}