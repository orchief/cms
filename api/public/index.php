<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// [ 应用入口文件 ]

/*防止跨域*/
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, authorization");
    header('Access-Control-Expose-Headers: authorization'); // 
    // Access-Control-Expose-Headers : 'Authorization';
    if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
        die;
    }
}

define('APP_PATH', __DIR__ . '/../application/');
// 定义配置文件目录和应用目录同级
define('CONF_PATH', __DIR__.'/../config/');

// 加载框架引导文件
require __DIR__ . '/../thinkphp/5.0.7/start.php';