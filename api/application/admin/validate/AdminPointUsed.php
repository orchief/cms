<?php
// +----------------------------------------------------------------------
// | Description: 积分使用方式列表
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------
// | Date: 2018-09-06 13:12:59
// +----------------------------------------------------------------------

namespace app\admin\validate;

use app\Validate;

class AdminPointUsed extends Validate
{
    protected $rule = array(
        'status' => 'require|in:0,1',
        'title' => 'require',
        'contents' => 'require',
        'remark' => 'require',
    );
    protected $field = array(
        'status' => '是否开启积分抵现 0 未激活  1 激活',
        'title' => '使用积分方式',
        'contents' => '具体配置',
        'remark' => '详细解释',
    );
    protected $scene = [
        "create" => ["contents","remark","status","title"],
        "update" => [
            "status" => "require|in:0,1",
            "title" => "require",
            "contents" => "require",
            "remark" => "require",
        ]
    ];
}
