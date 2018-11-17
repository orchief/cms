<?php
// +----------------------------------------------------------------------
// | Description: jssdk授权
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------
// | Date: 2018-01-31 13:40:28
// +----------------------------------------------------------------------

namespace app\base\controller;

use EasyWeChat\Factory;

class WxConfig extends Base
{
    public function index()
    {
        $this->param['configUrl'] = 'http://api.shop.pstech360.com/h5/shouyintai.html';
        abort_if($this->param['configUrl'], ['msg' => 'configUrl不能为空']);
        $configs = setting('WECHAT');
        $config = [
            // 必要配置
            'app_id' => $configs['app_id'],
            'mch_id' => $configs['mch_id'],
            'key'    => $configs['key'], 
            'secret' => $configs['secret']
        ];
        $app = Factory::payment($config);
        $APIs = ['chooseWXPay', 'onMenuShareWeibo'];
        $url = $this->param['configUrl'];
        $app->jssdk->setUrl($url);
        $res = $app->jssdk->buildConfig($APIs, $debug = false, $beta = false, $json = true);
        $resArr = json_decode($res, true);
        result($resArr);
    }
}