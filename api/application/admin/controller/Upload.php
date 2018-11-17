<?php
// +----------------------------------------------------------------------
// | Description: 图片上传 (因为数据库路径转义问题  以下路径只考虑了windows系统 linux系统需要在使用路径的接口进行替换处理)
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\Controller;
use think\Request;

class Upload extends Controller
{
    public function index()
    {
        $file = request()->file('file');
        abort_if($file, '请上传文件');
        $info = $file->validate(['ext' => 'jpg,png,gif'])->move(ROOT_PATH . DS . 'public' . DS . 'uploads');
        abort_if($info, '文件上传失败');
        result('uploads' . '/' . str_replace('\\', '/', $info->getSaveName()));
    }

    /**
     * 多图上传
     */
    public function uploads()
    {     
        $files = request()->file('file');
        abort_if($files, '请上传图片！');
        foreach ($files as $key => $file) {
            $info = $file->validate(['ext' => 'jpg,png,gif'])->move('./uploads');
            abort_if($info, $file->getError());
            $path[] = 'uploads' .'/'. $info->getSaveName();
        }
        result(count($path), $path);
    }

    /**
     * base64格式图片
     *
     * @return void
     */
    public function base64()
    {
        $date = date("Ymd");
        if(preg_match('/^(data:\s*image\/(\w+);base64,)/', $this->param['base64'], $result)){
           $img = base64_decode(str_replace($result[1], '', $this->param['base64']));
        }
        $ext = $result[2];
        $pic = 'uploads' . '/' . $date . '/' . md5(time() . mt_rand(100, 999)) . '.' . $ext;
        $dir = ROOT_PATH . '/public/uploads/' . $date;
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        $info = file_put_contents(ROOT_PATH . '/public/' . $pic, $img); //保存图片，返回的是字节数
        result($pic, '图片上传失败');
    }
}
