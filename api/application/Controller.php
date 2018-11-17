<?php
// +----------------------------------------------------------------------
// | Description: 解决跨域问题
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------

namespace app;

use think\Controller as ThinkController;
use think\Request;

class Controller extends ThinkController
{
    /**
     * 前台参数列表
     *
     * @var [type]
     */
    public $param;
    protected $model;
    public function _initialize()
    {
        parent::_initialize();
        // 接收参数 简化后续参数使用难度
        $this->param = Request::instance()->param();

        // 发放唯一的jwt token字符串
        session_start();
        if(!JWT::get('sessionId')){
            $sessionId = session_id();
            JWT::set('sessionId', $sessionId);
        }
    }

    /**
     * 实例化model 如果是本控制器对应的model则暂存
     */
    protected function model($name = null){
        if(null == $name){
            $name = $this->modelName;
        }
        if($this->modelName == $name){
            if(isset($this->model)){
                return $this->model;
            }
            $this->model = \think\Loader::model($name, 'model', false);
            return $this->model;
        }else{
            return \think\Loader::model($name, 'model', false);
        }
    }
}
