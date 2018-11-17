<?php
// +----------------------------------------------------------------------
// | Description: Address management
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------
// | Date: 2018-01-31 13:40:28
// +----------------------------------------------------------------------

namespace app\base\controller;
use think\Hook;
class Swagger extends Base
{
    /**
     * 自动生成swagger-ui所需的json文件
     *
     * @return void
     */
    public function index(){
        $content = ['orderId' => 4436];
        Hook::listen('sendVip', $content);
        echo 11;
        // set_time_limit(0);
   
        // header('Content-Type: application/json');

        // // try{
        // //     $openapi = \Swagger\scan(APP_PATH . '/shop/');
        // //     file_put_contents(ROOT_PATH . '/public/'. 'api.json', $openapi);
        // // }catch(\Exception $e){
        //     $openapi = file_get_contents(ROOT_PATH . '/public/'. 'api.json');
        // // }
        // echo $openapi;
    }
}