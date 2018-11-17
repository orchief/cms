<?php
// +----------------------------------------------------------------------
// | Description: 用户组
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\admin\model;

use app\admin\common\model\Model;

class Group extends Model
{
    protected $name = 'admin_group';

    /**
     * [getDataList 获取列表]
     * @linchuangbin
     * @DateTime  2017-02-10T21:07:18+0800
     * @return    [array]
     */
    public function getDataList($param)
    {
        $cat = new \com\Category('admin_group', array('id', 'pid', 'title', 'title'));
        $data = $cat->getList('', 0, 'id');

        return $data;
    }

    /**
     * [delDataById 根据id删除数据]
     * @linchuangbin
     * @DateTime  2017-02-11T20:57:55+0800
     * @param     string                   $id     [主键]
     * @param     boolean                  $delSon [是否删除子孙数据]
     * @return    [type]                           [description]
     */
    public function delDataById($id = '', $delSon = false)
    {
        // 检查当前用户组下是否存在用户
        $num = db('admin_access')->where('group_id', '=', $id)->count();
        if ($num) {
            $this->error = '当前用户组下存在用户';
            return false;
        }

        try {
            $this->where($this->getPk(), $id)->delete();
            return true;
        } catch (\Exception $e) {
            $this->error = '删除失败';
            return false;
        }
    }

    /**
     * [delDatas 批量删除数据]
     * @linchuangbin
     * @DateTime  2017-02-11T20:59:34+0800
     * @param     array                   $ids    [主键数组]
     * @param     boolean                 $delSon [是否删除子孙数据]
     * @return    [type]                          [description]
     */
    public function delDatas($ids = [], $delSon = false)
    {
        // 检查当前用户组下是否存在用户
        $num = db('admin_access')->where('group_id', 'in', $ids)->count();
        if ($num) {
            $this->error = '当前用户组下存在用户';
            return false;
        }
        try {
            $this->where($this->getPk(), 'in', $ids)->delete();
            return true;
        } catch (\Exception $e) {
            $this->error = '操作失败';
            return false;
        }
    }
}
