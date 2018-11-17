<?php
// +----------------------------------------------------------------------
// | Description: 微信支付回调
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------
// | Date: 2018-01-31 13:40:28
// +----------------------------------------------------------------------

namespace app\base\controller;

use EasyWeChat\Factory;
use think\Db;
use think\Hook;

class WechatNotify extends Base
{
    /**
     * @return void
     */
    public function index(){
        // TODO 接收微信支付成功推送 并处理
        $configs = setting('WECHAT');

        $config = [
            // 必要配置
            'app_id'        => $configs['app_id'], 
            'mch_id'        => $configs['mch_id'],
            'key'           => $configs['key'] // API 密钥
        ];
        $app = Factory::payment($config);

        $response = $app->handlePaidNotify(function($message, $fail){
            // file_put_contents('message'.time().'.txt', json_encode($message));

            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            $orderInfo = Db::table('shop_orders')->where(['id' => $message['out_trade_no']])->find();

            // file_put_contents('orderInfo'.time().'.txt', json_encode($orderInfo));
        
            if (!$orderInfo || $orderInfo['status'] != 0) { // 如果订单不存在 或者 订单已经支付过了
                // file_put_contents('true'.time().'.txt', json_encode($orderInfo));
                return true; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }
        
            ///////////// <- 建议在这里调用微信的【订单查询】接口查一下该笔订单的情况，确认是已经支付 /////////////
            // file_put_contents('true2'.time().'.txt', json_encode($orderInfo));
            if ($message['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
                // file_put_contents('return_code_success'.time().'.txt', json_encode($orderInfo));
                // 用户是否支付成功
                if ($message['result_code'] == 'SUCCESS') {
                    // file_put_contents('SUCCESS'.time().'.txt', json_encode($orderInfo));
                    $this->paySuccess(['orderId' => $orderInfo['id']], $orderInfo);

                // 用户支付失败
                } elseif (array_get($message, 'result_code') === 'FAIL') {
                    // file_put_contents('elseif'.time().'.txt', json_encode($orderInfo));
                }
            } else {
                // file_put_contents('通信失败，请稍后再通知我'.time().'.txt', json_encode($orderInfo));
                return $fail('通信失败，请稍后再通知我');
            }

            return true; // 返回处理完成
        });
        
        $response->send(); // return $response;
    }

    /**
     * 支付成功后续逻辑
     *
     * @return void
     */
    function paySuccess($content, $orderInfo)
    {
        // file_put_contents('content'.time().'content.txt', json_encode($content));
        // TODO 商品为虚拟产品直接到账
        if($orderInfo['addressId'] == 0){
            $status = 4;
        }else{
            $status = 2;
        }
        Db::table('shop_orders_status_pay')->where(['orderId' => $content['orderId']])->update(['status' => $status]);
        // TODO VIP卡发放 支付成功之后将卡状态调整为可用
        Hook::listen('sendVip', $content);
    }
}