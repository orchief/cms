<?php
// +----------------------------------------------------------------------
// | Description: 三方配置信息
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------
// | Date: 2018-09-07 15:31:10
// +----------------------------------------------------------------------

namespace app\admin\controller;

use app\admin\common\controller\Rest;

class Setting extends Rest
{
    public $modelName = 'Setting';
    public $index;
    public $read;
    public $update;
    public function update()
    {
        $this->param['value'] = json_encode($this->param['value'], JSON_UNESCAPED_UNICODE);
        parent::update();
    }
}