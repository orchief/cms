<?php
namespace app;

use Exception;
use think\exception\Handle;
use think\exception\HttpException;
use think\Log;
use think\Request;
class HandleException extends Handle
{
    public function render(Exception $e)
    {
        // TODO 判断是否为静态资源
        $res = ['code' => 500, 'msg' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile(), 'trace' => $e->getTrace(), 'previous' => $e->getPrevious(), 'param' => Request::instance()->param()];
        // TODO 记录日志
        Log::debug($res);
        header('Content-Type:application/json; charset=utf-8');
        return response($res, 200, [], 'json');
    }
}