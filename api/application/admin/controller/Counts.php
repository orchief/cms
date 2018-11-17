<?php
// +----------------------------------------------------------------------
// | Description: 平台信息统计
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------

namespace app\admin\controller;

use app\admin\common\controller\Rest;

class Counts extends Rest
{
    public $index;
    public function index()
    {
        // TODO 待发货订单
        $pendingDeliveryOrderCounts = $this->model('Orders')->getPendingDeliveryOrders();

        // TODO 今日订单
        $todayOrderCounts = $this->model('Orders')->getTodayOrders();

        // TODO 今日成交额
        $todayOrderTotalMoney = (double)$this->model('Orders')->getTodayOrderTotalMoney();

        // TODO 昨日订单
        $yestodayOrderCounts = (double)$this->model('Orders')->getYestodayOrders();

        // TODO 昨日成交额
        $yestodayOrderTotalMoney = (double)$this->model('Orders')->getYestodayOrderTotalMoney();

        // TODO 售后订单
        $refundOrderCounts = (double)$this->model('Orders')->getRefundOrderCounts();

        // TODO 商品数量
        $productsCounts = (double)$this->model('GoodsProducts')->getProductsCounts();

        // TODO 会员数量
        $membersCounts = (double)$this->model('Members')->getMembersCounts();

        // TODO 分销商数量
        $agentCounts = (double)$this->model('Members')->getAgentCounts();

        // TODO 最近7天 按日为单位 订单 / 分销商 / 会员
        $MembersDaily = $this->model('MembersDaily')->getDataList([]);
        $OrdersDaily = $this->model('OrdersDaily')->getDataList([]);
        $AgentDaily = $this->model('AgentDaily')->getDataList([]);
        
        // TODO 7天分销商 / 会员 排名 取前8名
        $rankAgent = $this->model('Members')->getAgentRanks();
        $rankMembers = $this->model('Members')->getMembersRanks();
        
        $res = compact(
            'pendingDeliveryOrderCounts', 
            'todayOrderCounts', 
            'yestodayOrderCounts',
            'todayOrderTotalMoney',
            'yestodayOrderTotalMoney', 
            'refundOrderCounts', 
            'productsCounts', 
            'membersCounts', 
            'agentCounts', 
            'MembersDaily',
            'OrdersDaily',
            'AgentDaily',
            'rankAgent',
            'rankMembers'
        );

        result($res);
    }
}
