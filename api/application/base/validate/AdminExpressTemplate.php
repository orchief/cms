<?php
// +----------------------------------------------------------------------
// | Description: 物流模板管理
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------
// | Date: 2018-09-04 16:56:23
// +----------------------------------------------------------------------

namespace app\base\validate;

use app\Validate;

class AdminExpressTemplate extends Validate
{
    protected $rule = array(
        'name' => 'require',
        'munit' => 'require',
        'freeShip' => 'require',
    );
    protected $field = array(
        'name' => '公司名称',
        'munit' => '计价方式 1 按件  2 按重量 3 按体积',
        'freeShip' => '是否免除运费  1 免除 0 自定义',
    );
    protected $scene = [
        "create" => [],
        "update" => [
            "name" => "require",
            "munit" => "require",
            "freeShip" => "require",
        ]
    ];
}
