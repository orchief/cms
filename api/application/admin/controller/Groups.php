<?php
// +----------------------------------------------------------------------
// | Description: 角色管理
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------

namespace app\admin\controller;

use app\admin\common\controller\Rest;

class Groups extends Rest
{
    public $modelName = 'Group';
    public $index;
    public $read;
    public $save;
    public $update;
    public $delete;
    public $enables;
}
