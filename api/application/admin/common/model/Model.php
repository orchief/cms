<?php
// +----------------------------------------------------------------------
// | Description: 公共模型,所有模型都可继承此模型，基于RESTFUL CRUD操作
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------

namespace app\admin\common\model;

use  app\Model as AppModel;
use think\Config;

class Model extends AppModel
{

    public function __construct($data = [])
    {
        parent::__construct($data);
        $param = \think\Request::instance()->param();
        if(isset($param['fields'])){
            $this->visible = array_diff(explode(',', $param['fields']), $this->hidden); // 设为隐藏的优先
        }
        if(!$this->returnFields){
            $this->returnFields = implode(',', $this->visible);
        }
    }
    
    /**
     * 多条件获取数据列表
     */
    public function getDataList($param)
    {
        $res = $this->parseParam($param);
        $total = $this->getTotals($param);
        $res = $this->modelToArray($res);
        $res =  $this->filter($res);
        $resData['list'] = $res;
        $resData['dataCount'] = $total;
        return $resData;
    }

    /**
     * 模型查询结果 对象转数组
     *
     * @param [type] $res
     * @return void
     */
    public function modelToArray($res)
    {
        if(is_array($res)){
            $arr = [];
            foreach($res as $k => $v){
                $arr[] = $v->data;
            }
        }else{
            $arr[] = $res->data;
        }
        return $arr;
    }

    /**
     * 获取一条数据
     *
     * @param [type] $param
     * @return void
     */
    public function getDataById($id)
    {
        // 联合查询
        if ($this->leftJoin) {
            foreach ($this->leftJoin as $k => $v) {
                $this->join($v[0], $v[0].'.'.$v[1] . '=' . $this->name . '.' . $v[2], 'LEFT');
            }
        }
        $res = $this->where($this->name . '.' . $this->pk, $id)->field($this->returnFields)->select();
        return  $this->filter($this->modelToArray($res))[0];
    }

    /**
     * 自定义 过滤数据库查询结果
     *
     * @return void
     */
    public function filter($data)
    {
        return $data;
    }
    /**
     * [createData 新建]
     * @linchuangbin
     * @DateTime  2017-02-10T21:19:06+0800
     * @param     array                    $param [description]
     * @return    [array]                         [description]
     */
    public function createData($param)
    {
        // 验证
        $validate = validate($this->name);
        abort_if(!$validate->hasScene('create') or $validate->scene('create')->check($param), ['msg' => $validate->getError()]);
        // 插入数据
        try {
            $this->allowField(true)->data($param)->save();
        } catch (\Exception $e) {
            if(Config::get('app_debug')){
                abort(['msg' => $e->getMessage()]);
            }
            abort(['msg' => '新建数据失败!']);
        }
    }

    /**
     * 通过主键id修改用户
     * @param  array   $param  [description]
     */
    public function updateDataById($param, $id, $fields = true, $pk = 'id')
    {
        // 验证
        $validate = validate($this->name);
        abort_if(!$validate->hasScene('update') or $validate->scene('update')->check($param), ['msg' => $validate->getError()]);

        try {
            $this->allowField($fields)->save($param, [$pk => $id]);
        } catch (\Exception $e) {
            if(Config::get('app_debug')){
                abort(['msg' => $e->getMessage()]);
            }
            abort(['msg' => '编辑失败!']);
        }
    }

    /**
     * [delDataById 根据id删除数据]
     *
     * @param mixed $ids
     * @return void
     */
    public function delDatas($ids)
    {
        $this->beRelated($ids);
        if($this->softDelete == true){
            return $this->softDelDatas($ids);
        }else{
            try {
                if(is_array($ids)){
                    abort_if(!empty($ids), ['msg' => '删除失败!']);
                    $this->where($this->pk, 'in', $ids)->delete();
                }else{
                    $this->beRelated($ids);
                    $this->where($this->pk, $ids)->delete();
                }
            } catch (\Exception $e) {
                if(Config::get('app_debug')){
                    abort(['msg' => $e->getMessage()]);
                }
                abort(['msg' => '删除失败!']);
            }
        }
        return true;
    }

    /**
     * 软删除数据 通过将isDelete字段设置为删除时候的时间戳来实现软删除 并同时记录删除时间
     *
     * @param array $ids
     * @param string $delField
     * @return void
     */
    public function softDelDatas($ids = [])
    {
        try {
            if(is_array($ids)){
                abort_if(!empty($ids), ['msg' => '删除失败!']);
                $this->where($this->pk, 'in', $ids)->setField($this->delField, time());
            }else{
                $this->where($this->pk, $ids)->setField($this->delField, time());
                $sql = $this->getLastSql();
            }
        } catch (\Exception $e) {
            if(Config::get('app_debug')){
                abort(['msg' => $e->getMessage()]);
            }
            abort(['msg' => '删除失败!']);
        }
        return true;
    }

    /**
     * 某个字段在几个选项直接切换 支持批量操作
     * @AuthorHTL
     * @DateTime  2017-02-11T21:01:58+0800
     * @param     string                   $ids    [主键数组]
     * @param     integer                  $status [状态1启用0禁用]
     * @param     string                   $fieldName [要修改状态的字段名称 默认status]
     * @return    [type]                   [description]
     */
    public function switchFileds($ids = [], $value = 1, $fieldName = "status")
    {
        abort_if(!empty($ids), ['msg' => '请传入要修改的条目!']);
        try {
            $this->where($this->pk, 'in', $ids)->setField($fieldName, $value);
        } catch (\Exception $e) {
            if(Config::get('app_debug')){
                abort(['msg' => $e->getMessage()]);
            }
            abort(['msg' => '修改失败!']);
        }
    }

    /**
     * 将数组中某一个字段的值从字符串转换为数组 从而返回一个多级树形结构
     *
     * @param array $list 数据数组
     * @param array $fields 要转换的字段列表
     * @return array $list 转换之后的数组
     */
    public function fieldToJson(Array $list, Array $fields = [])
    {
        foreach($list as $k => $v){
            foreach($fields as $kk => $vv){
                if(is_string($list[$k][$vv])){
                    $temp = json_decode($list[$k][$vv]);
                    if(null != $temp or null == $list[$k][$vv]){
                        $list[$k][$vv] = $temp;
                    }
                }
            }
        }
        return $list;
    }

    /**
     * 当前记录是否存在关联表
     */
    protected function beRelated($ids)
    {
        if(count($this->relates)){
            foreach($this->relates  as $k_rel => $v_rel){
                if(is_array($ids)){
                    foreach($ids as $v){
                        $count = model($v_rel['model'])->where([$v_rel['field'] => $v])->count();
                        abort_if(!$count, ['msg' => $v_rel['msg']]);
                    }
                }else{
                    $count = model($v_rel['model'])->where([$v_rel['field'] => $ids])->count();
                        abort_if(!$count, ['msg' => $v_rel['msg']]);
                }
            }
        }
    }
}
