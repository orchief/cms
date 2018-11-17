<?php
// +----------------------------------------------------------------------
// | Description: 地址接口服务
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------
// | Date: 2018-09-04 16:45:51
// +----------------------------------------------------------------------

namespace app\base\validate;

use app\Validate;

class BaseAddress extends Validate
{
    protected $rule = array(
        'areaId' => 'require',
        'areaCode' => 'require',
        'areaName' => 'require',
        'level' => 'require',
        'cityCode' => 'require',
        'center' => 'require',
        'parentId' => 'require',
    );
    protected $field = array(
        'areaId' => '地区Id',
        'areaCode' => '地区编码',
        'areaName' => '地区名',
        'level' => '地区级别（1:省份province,2:市city,3:区县district,4:街道street）',
        'cityCode' => '城市编码',
        'center' => '城市中心点（即：经纬度坐标）',
        'parentId' => '地区父节点',
    );
    protected $scene = [
        "create" => ["areaId","areaCode","areaName","cityCode","center",],
        "update" => [
            "areaId" => "require",
            "areaCode" => "require",
            "areaName" => "require",
            "level" => "require",
            "cityCode" => "require",
            "center" => "require",
            "parentId" => "require",
        ]
    ];
}
