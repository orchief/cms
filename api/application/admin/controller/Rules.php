<?php
// +----------------------------------------------------------------------
// | Description: 权限规则
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------

namespace app\admin\controller;

use app\admin\common\controller\Rest;

class Rules extends Rest
{
    public $modelName = 'Rule';
    public $index;
    public $read;
    public $save;
    public $update;
    public $delete;
    public $enables;
}
