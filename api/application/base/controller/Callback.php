<?php
// +----------------------------------------------------------------------
// | Description: 获取openid
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------
// | Date: 2018-01-31 13:40:28
// +----------------------------------------------------------------------

namespace app\base\controller;

use EasyWeChat\Factory;


class Callback extends Base
{
    /**
     * 自动生成swagger-ui所需的json文件
     *
     * @return void
     */
    public function index(){
        $configs = setting('WECHAT');
        // p(1);
        $config = [
            'app_id' => $configs['app_id'],
            'secret' => $configs['secret'],

            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',
            'oauth' => [
                'scopes' => ['snsapi_base'],
                'callback' => '/base/oauth_callback',
            ],
            'log' => [
                'level' => 'debug',
                'file' => __DIR__ . '/wechat.log',
            ],
        ];
        $app = Factory::officialAccount($config);
        $oauth = $app->oauth;

        // 获取 OAuth 授权结果用户信息
        $user = $oauth->user();

        $user->getId();

        $callback = '/h5/shouyintai.html';  // 授权回调前端地址

        header('Location: '. $callback .'?openid='.$user->getId());
    }
}