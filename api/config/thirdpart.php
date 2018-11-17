<?php
// +----------------------------------------------------------------------
// | Description: 第三方配置文件
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------
return [
    // 短信接口配置
    'smsConf' => [
        'sendUrl' => 'http://v.juhe.cn/sms/send',
        'key' => 'f227035ff9563405d0bc102a882bbffe', //您申请的APPKEY
        'tpl_id' => '79629', //您申请的短信模板ID，根据实际情况修改
        'company' => '梵丝商城',
        'length' => 4, // 短信验证码长度 (4-8位)
    ],

    // 快递接口配置
    'express' => [
        'sendUrl' => 'http://poll.kuaidi100.com/poll/query.do',
        'key' => 'NdPqaeux7296',
        'com' => 'shunfeng', //请求的物流公司编码  这里默认为顺风 shunfeng
        'customer' => '4EB8F3148B0AADB6C152553E9AD582CF',
    ],

    // 微信支付
    'wechat' => [
        'app_id' => 'wxfdad2cc665f379db',
        'mch_id' => '',
        'key' => '',
        'secret' => 'c459f1c0e148f3819cf25e0104a7c662',
    ],
];
