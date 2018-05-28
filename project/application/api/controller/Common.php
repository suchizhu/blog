<?php
namespace app\api\controller;

use think\Controller;

class Common extends Controller
{
    // 头像上传
    public function uploadAvatar()
    {
        // 获取已上传头像路径、图片id和当前上传头像的信息
        $path = '.' . $this->request->post('path');
        $imageId = $this->request->post('image_id');
        $file = $this->request->file('image');

        // 验证当前上传头像信息是否符合条件并保存
        $info = $file->validate(['size' => 50 * 1024, 'ext' => 'jpg,png,gif'])->move('public/uploads');

        // 当前头像上传成功
        if ($info) {
            // 判断已上传头像路径是否为空且存在
            if (!empty($path && file_exists($path))) {
                unlink($path);
            }

            // 获取当前头像上传路径
            $avatar = '/' . $info->getPathname();

            // 当$imageId 为0时，代表正在上传的头像为 用户默认头像上传
            if($imageId == 0){
                model('image')->save(['src' => $avatar, 'is_default'=> 1]);
            }else{
                model('image')->save(['src' => $avatar], ['id' => $imageId]);
            }

            return $this->result($avatar, 0, '头像上传成功');
        } else {
            return $this->result('', 1, $file->getError());
        }
    }

    // 图片上传
    public function uploadImage()
    {
        $path = $this->request->post('path');
        $file = $this->request->file('file');
        $info = $file->move('public/uploads');
        if ($info) {
            if (file_exists($path) && !empty($path)) {
                unlink($path);
            }
            $src = $info->getPathname();
            model('image')->save(['src'=> '/' . $src]);
            $id = model('image')->getLastInsID();
            $data = [
                "src" => $src,
                "id"  => $id
            ];
            return $this->result($data, 0, '图片上传成功');
        } else {
            return $this->result('', 1, $file->getError());
        }
    }
}