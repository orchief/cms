<?php
// +----------------------------------------------------------------------
// | Description: 岗位
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\admin\model;

use app\admin\common\model\Model;

class Post extends Model
{

    protected $name = 'admin_post';
    protected $createTime = 'create_time';
    protected $updateTime = false;
    protected $autoWriteTimestamp = true;
    protected $insert = [
        'status' => 1,
    ];

    /**
     * [getDataList 获取列表]
     * @linchuangbin
     * @DateTime  2017-02-10T21:07:18+0800
     * @return    [array]
     */
    public function getDataList($keywords)
    {
        $map = [];
        if ($param['keywords']) {
            $map['name'] = ['like', '%' . $keywords . '%'];
        }
        $data = $this->where($map)->select();
        return $data;
    }
}
