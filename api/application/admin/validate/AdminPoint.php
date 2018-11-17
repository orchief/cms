<?php
// +----------------------------------------------------------------------
// | Description: 获取积分的事件列表
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------
// | Date: 2018-09-04 15:26:42
// +----------------------------------------------------------------------

namespace app\admin\validate;

use app\Validate;

class AdminPoint extends Validate
{
    protected $rule = array(
        'title' => 'require',
        'points' => 'require|float',
        'remark' => 'require',
    );
    protected $field = array(
        'title' => '事件名称',
        'points' => '赠送积分数量',
        'remark' => '详细解释',
    );
    protected $scene = [
        "create" => ["remark","title","points"],
        "update" => [
            "title" => "require",
            "points" => "require",
            "remark" => "require",
        ]
    ];
}
