<?php
// +----------------------------------------------------------------------
// | Description: 公共路由
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------

return [
    'swagger' => 'base/Swagger/index',
    'OauthCallback' => 'base/OauthCallback/index',
    'base/OauthCallback' => 'base/OauthCallback/index',
    'shop/members' => ['shop/Members/index', ['method' => 'Get']],
    'shop/members' => ['shop/Members/update', ['method' => 'Put']],
    'shop/members' => ['shop/Members/save', ['method' => 'Post']],
    'admin/MembersCash/enables' => ['admin/MembersCash/enables', ['method' => 'Post']],
    'admin/MembersVip/enables' => ['admin/MembersVip/enables', ['method' => 'Post']],
    'admin/MembersAgentApply/enables' => ['admin/MembersAgentApply/enables', ['method' => 'Post']],
    'shop/memberscart/deletes' => ['shop/MembersCart/deletes', ['method' => 'Post']],
    'wechatnotify' => ['base/WechatNotify/index', ['method' => 'Post']],
    'admin/login' => ['admin/base/login', ['method' => 'POST']],
    'verify' => ['admin/base/getVerify', ['method' => 'GET']],
    'shop/Members/password' => ['shop/Members/password', ['method' => 'POST']],
    'admin/GoodsAttributeToValues/saves' => ['admin/GoodsAttributeToValues/saves', ['method' => 'POST']],
    'admin/GoodsAttributeToValues/deletes' => ['admin/GoodsAttributeToValues/deletes', ['method' => 'POST']],
    'admin/GoodsAttributeToGroup/saves' => ['admin/GoodsAttributeToGroup/saves', ['method' => 'POST']],
    'admin/GoodsAttributeToGroup/deletes' => ['admin/GoodsAttributeToGroup/deletes', ['method' => 'POST']],
];