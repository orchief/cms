<?php
// +----------------------------------------------------------------------
// | Description: 系统操作日志
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------

namespace app\admin\controller;

use app\admin\common\controller\Rest;

class Signlogs extends Rest
{
    public $modelName = 'SignLog';
    public $index;
    public $save;
    public $update;
    public $delete;
    public $deletes;
}
