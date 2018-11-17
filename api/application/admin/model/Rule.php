<?php
// +----------------------------------------------------------------------
// | Description: 规则
// +----------------------------------------------------------------------
// | Author: dongpeng
// +----------------------------------------------------------------------

namespace app\admin\model;

use app\admin\common\model\Model;

class Rule extends Model
{
    protected $name = 'admin_rule';
    /**
     * [getDataList 获取列表]
     * @linchuangbin
     * @DateTime  2017-02-10T21:07:18+0800
     * @param     string                   $type [是否为树状结构]
     * @return    [array]
     */
    public function getDataList($param)
    {
        $cat = new \com\Category('admin_rule', array('id', 'pid', 'title', 'title'));
        $data = $cat->getList('', 0, 'id');
        // 若type为tree，则返回树状结构
        if ($param['type'] == 'tree') {
            foreach ($data as $k => $v) {
                $data[$k]['check'] = false;
            }
            $tree = new \com\Tree();
            $data = $tree->list_to_tree($data, 'id', 'pid', 'child', 0, true, array('pid'));
        }

        return $data;
    }

}
