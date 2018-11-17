<?php
namespace app;

/**
 * 一键生成rest接口
 */
use think\Model as ThinkModel;

use think\config;


class Model extends ThinkModel
{
    use Url2Sql;
    /**
     * 控制器处理过的前端请求参数
     *
     * @var array
     */
    protected $param;
    /**
     * 排序字段
     * 值为: fieldName.desc 表示fieldName 字段倒叙
     * 值为: fieldName.asc 表示fieldName 字段正序
     * 
     * @var string
     */

    /**
     * 删除关联检测 包含批量和单个 可以检测多个从表
     * 值为: fieldName.desc 表示fieldName 字段倒叙
     * 值为: fieldName.asc 表示fieldName 字段正序
     * 
     * @var string
     */
     protected $relates = [
        // [
        //     'table' => 'shop_goods_products',        // 需检测的关联表名
        //     'field' => 'categoryId',                 // 对应的键名
        //     'model' => 'GoodsProducts',              // table对应的model名称
        //     'msg'   => '当前规格不能删除'              // 检测未通过的错误信息
        // ]
     ];

    /**
     * 排序字段
     * 值为: fieldName.desc 表示fieldName 字段倒叙
     * 值为: fieldName.asc 表示fieldName 字段正序
     * 
     * @var string
     */
    protected $orderStr;
    /**
     * 允许主表  精确查询的字段 会被转换成 = 
     *
     * @var array
     */
    protected $eqCons = [];
    /**
     * 允许主表 模糊查询的字段 会被转换成 like 并且值两边会被加上 %
     *
     * @var array
     */
    protected  $likeCons  = [];
    protected  $joinLikeCon = [];
    protected  $joinEqCon = [];
    /**
     * 允许范围查询的字段 支持单段查询
     * 例子: fieldName=1,100  // 查询出 1 到 100 之间的值
     * 例子: fieldName=1,     // 查询出 大于 1 的值
     * 例子: fieldName=,100   // 查询出 小于 100 的值
     *
     * @var array
     */
    protected $ranges = [];
    /**
     * 联合查询 left join的普通封装
     *
     * @var array
     */
    protected $leftJoin = [
        // [
        //     'tablename',        // left join的表名
        //     'tablename_id',     // left join 的表的对应键
        //     'main_id'           // 主表对应的键
        // ]
    ];
    /**
     * 默认 每页条数
     *
     * @var integer
     */
    protected $limit = 20;
    /**
     * 当前跳过条数 默认不跳过
     *
     * @var integer
     */
    protected $offset = 0;
     /**
     * select 后边的字符串 返回的字段
     *
     * @var array
     */
    protected $returnFields = '';
    /**
     * 只读字段 禁止update的字段
     *
     * @var array
     */
    protected $readonly = [];
    /**
     * 是否开启软删除 开启软删除必须在数据库表添加 isDelete字段 类型为int
     *
     * @var boolean
     */
    protected $softDelete = false;
    /**
     * 隐藏字段 无法查询的字段 read / index不显示的字段
     * @var boolean
     */
    protected $hidden = ['userId'];
    /**
     * 显示字段 不设置会返回所有字段 
     * @var boolean
     */
    protected $visible = [];
    /**
     * 默认软删除字段名称
     *
     * @var boolean
     */
    protected $delField = 'isDelete';
    /**
     * 主键id
     *
     * @var string
     */
    protected $pk = 'id';

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
        $res = $this->modelToArray($res);
        return  $this->filter($res);
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
        $res = $this->where($this->name . '.' . $this->pk, $id)->field($this->returnFields)->find();
        return  $this->filter([$res])[0];
    }

    public function getDataListCount($param)
    {
        $res = $this->parseParam($param)->count();
        return  $this->filter($res);
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
            $this->data($param)->allowField(true)->save();
        } catch (\Exception $e) {
            if(config::get('app_debug')){
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
            if(config::get('app_debug')){
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
        if($this->softDelete == true){
            return $this->softDelDatas($ids);
        }else{
            try {
                if(is_array($ids)){
                    abort_if(!empty($ids), ['msg' => '删除失败!']);
                    $this->where($this->pk, 'in', $ids)->delete();
                }else{
                    $this->where($this->pk, $ids)->delete();
                }
            } catch (\Exception $e) {
                if(config::get('app_debug')){
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
            if(config::get('app_debug')){
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
            if(config::get('app_debug')){
                abort(['msg' => $e->getMessage()]);
            }
            abort(['msg' => '修改失败!']);
        }
    }

           /**
     * [enableDatas 批量启用、禁用]
     * @AuthorHTL
     * @DateTime  2017-02-11T21:01:58+0800
     * @param     string                   $ids    [主键数组]
     * @param     integer                  $status [状态1启用0禁用]
     * @param     string                   $fieldName [要修改状态的字段名称 默认status]
     * @return    [type]                           [description]
     */
    public function enableDatas($ids = [], $value = 1, $fieldName = "status")
    {
        if (empty($ids)) {
            $this->error = '请传入要修改的条目';
            return false;
        }

        try {
            $this->where($this->pk, 'in', $ids)->setField($fieldName, $value);
            return true;
        } catch (\Exception $e) {
            $this->error = $e -> getMessage();
            return false;
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
}