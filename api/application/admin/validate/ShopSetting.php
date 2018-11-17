<?php
// +----------------------------------------------------------------------
// | Description: 三方配置信息
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------
// | Date: 2018-09-07 15:31:10
// +----------------------------------------------------------------------

namespace app\admin\validate;

use app\Validate;

class ShopSetting extends Validate
{
    protected $rule = array(
        'value' => 'require',
    );
    protected $field = array(
        'title' => '后台前端使用的名22称',
        'name' => '程序使用的名称 全大写 下划线隔开',
        'value' => '配置值 会存储为一个json格式',
        'remark' => '参数注释',
    );
    protected $scene = [
        "create" => ["title","remark",],
        "update" => [
            "value" => "require"
        ]
    ];
}
