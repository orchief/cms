<?php
// +----------------------------------------------------------------------
// | Description: restFul风格 api接口基础类
// +----------------------------------------------------------------------
// | Author: dongpeng
// +----------------------------------------------------------------------

namespace app\base\common\controller;

use app\Controller;

class Rest extends Controller
{
    public $modelName = null;
    public function index()
    {
        $model = $this->model();
        $data = $this->model()->getDataList($this->param);
        result($data, model($this->modelName)->getError());
    }

    public function read()
    {
        $data = model($this->modelName)->getDataById($this->param['id']);
        result($data, ['msg' => '暂无此数据!']);
    }

    public function save()
    {
        model($this->modelName)->createData($this->param);
        result(['msg' => '添加成功!']);
    }

    public function update()
    {
        model($this->modelName)->updateDataById($this->param, $this->param['id']);
        result(['msg' => '更新成功!']);
    }

    public function delete()
    {
        $res = model($this->modelName)->delDatas($this->param['id']);
        result(['msg' => '删除成功!']);
    }

    public function deletes()
    {
        if(!is_array($this->param['ids'])){
            $this->param['ids'] = explode(',', $this->param['ids']);
        }
        $res = $this->model()->delDatas($this->param['ids']);

        result(['msg' => '删除成功!']);
    }

    public function enables()
    {
        if(!is_array($this->param['ids'])){
            $this->param['ids'] = explode(',', $this->param['ids']);
        }

        $res = $this->model()->enableDatas($this->param['ids'], $this->param['status']);
        result(['msg' => '更新成功!']);
    }
}
