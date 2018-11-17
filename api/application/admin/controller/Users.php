<?php
// +----------------------------------------------------------------------
// | Description: 系统用户
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\admin\common\controller\Rest;

class Users extends Rest
{
    public $modelName = 'User';
    public $index;
    public $read;
    public $save;
    public $update;
    public $delete;
    public $enables;
}
