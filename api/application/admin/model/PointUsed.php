<?php
// +----------------------------------------------------------------------
// | Description: 积分使用方式列表
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------
// | Date: 2018-09-06 13:12:59
// +----------------------------------------------------------------------

namespace app\admin\model;

use app\admin\common\model\Model;

class PointUsed extends Model
{
    protected $name = 'admin_point_used';
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
    protected $eqCons = ["title","contents","remark",];
    /**
     * 允许主表 精确查询的字段
     *
     * @var array
     */
    protected  $likeCons  = ["status",];
    /**
     * 允许范围查询的字段 支持单段查询
     *
     * @var array
     */
    protected $ranges = [];
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

    public function filter($list)
    {
        return $this->fieldToJson($list, ['contents']);
    }
}
