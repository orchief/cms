<?php
// +----------------------------------------------------------------------
// | Description: 地址接口服务
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------
// | Date: 2018-09-04 16:45:51
// +----------------------------------------------------------------------

namespace app\base\model;

use app\base\common\model\Model;
use think\Cache;

class Address extends Model
{
    protected $name = 'base_address';
    protected $param;
    /**
     * 排序字段
     *
     * @var string
     */
    protected $orderStr;
    /**
     * 允许主表 模糊查询的字段
     *
     * @var array
     */
    protected $eqCons = ["areaId","areaCode","areaName","cityCode","center","parentId",];
    /**
     * 允许主表 精确查询的字段
     *
     * @var array
     */
    protected  $likeCons  = ["level",];
    /**
     * 允许范围查询的字段 支持单段查询
     *
     * @var array
     */
    protected $ranges = ['level'];
    /**
     * 联合查询
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
     * 每页条数
     *
     * @var integer
     */
    protected $limit = 20;
    /**
     * 当前页码
     *
     * @var integer
     */
    protected $offset = 0;
     /**
     * select 后边的字符串
     *
     * @var array
     */
    protected $returnFields = '';
    /**
     * 只读字段
     *
     * @var array
     */
    protected $readonly = [];
    /**
     * 是否开启软删除
     *
     * @var boolean
     */
    protected $softDelete = false;
    /**
     * 隐藏字段
     * @var boolean
     */
    protected $hidden = ['userId'];
    /**
     * 显示字段
     * @var boolean
     */
    protected $visible = [];
    /**
     * 默认软删除字段
     *
     * @var boolean
     */
    protected $delField = 'isDelete';
    public function getDataList($param){
        // 缓存某些条件的结果
        if($param['level'] == '1,2' and $param['limit'] == -1){
            $address = Cache::get('address_level_1_2');
            if($address){
                return $address;
            }else{
                $res = $this->parseParam($param);
                $total = $this->getTotals($param);
                $list = $this->modelToArray($res);
                $tree = new \com\Tree();
                $list = $tree->list_to_tree($list, 'areaId', 'parentId', 'child', -1);
                $resData['list'] = $list;
                $resData['dataCount'] = $total;
                Cache::set('address_level_1_2', $resData);
                return $resData;
            }
        }else{
            $res = $this->parseParam($param);
            $total = $this->getTotals($param);
            $list = $this->modelToArray($res);
            if($param['tree'] == 1){
                $tree = new \com\Tree();
                $list = $tree->list_to_tree($list, 'areaId', 'parentId', 'child', -1);
            }            
            $resData['list'] = $list;
            $resData['dataCount'] = $total;
            return $resData;
        }
    }
}
