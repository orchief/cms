<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------
// | Date: 2018-10-10 14:20:33
// +----------------------------------------------------------------------

namespace app\admin\validate;

use app\Validate;

class ShopConfig extends Validate
{
    protected $rule = array(
        'name' => 'require',
        'value' => 'require',
        'remark' => 'require',
    );
    protected $field = array(
        'name' => '参数名称 建议用大写下划线的风格',
        'value' => '配置值',
        'remark' => '参数注释',
    );
    protected $scene = [
        "create" => ["remark",],
        "update" => [
            // "name" => "require",
            "value" => "require",
            // "remark" => "require",
        ]
    ];
}
