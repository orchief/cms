<?php
// +----------------------------------------------------------------------
// | Description: 系统配置
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------

namespace app\admin\controller;

use app\admin\common\controller\Rest;
use app\admin\model\SystemConfig;

class Configs extends Rest
{
    public $modelName = 'SystemConfig';
    
    public $index;
    public function index()
    {
        $systemConfig = cache('DB_CONFIG_DATA');
        if (!$systemConfig) {
            //获取所有系统配置
            $systemConfig = $this->model()->getDataList();
            // 检查是否抛出异常
            abort_if($systemConfig, '系统配置获取失败');
            cache('DB_CONFIG_DATA', null);
            cache('DB_CONFIG_DATA', $systemConfig, 36000); //缓存配置
        }
        result($systemConfig, '系统配置获取失败');
    }

    public $save;
}
