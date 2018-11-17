<?php
namespace app\command;

/**
 * 按照配置文件自动生成所有rest接口
 */
use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\console\input\Argument;
use think\console\input\Option;

class restAuto extends Command
{
    protected $config = [
        'shop/GoodsProducts' => ['-f', '-r', '-e商品'],
        'shop/GoodsBrand' => ['-f', '-r', '-e商品品牌'],
        'shop/GoodsCategories' => ['-f', '-r', '-e商品分类'],
        'shop/GoodsProductsAttributes' => ['-f', '-r', '-e商品规格'],
        'shop/Banners' => ['-f', '-r', '-e轮播图'],
        'shop/Discount' => ['-f', '-r', '-e折扣'],
        'shop/Members' => ['-f', '-cur', '-e用户'],
        'shop/MembersAccount' => ['-f', '-r', '-e交易记录'],
        'shop/MembersAddress' => ['-f', '-curd', '-e地址'],
        'shop/MembersBanks' => ['-f', '-curd', '-e银行卡'],
        'shop/MembersCart' => ['-f', '-curd', '-e购物车'],
        'shop/MembersCash' => ['-f', '-cur', '-e提现'],
        'shop/MembersCoupon' => ['-f', '-cur', '-e优惠券'],
        'shop/MembersOrders' => ['-f', '-cur', '-e订单状态统计'],
        'shop/MembersSms' => ['-f', '-c', '-e短信验证码'],
        'shop/Orders' => ['-f', '-c', '-e订单'],
        'shop/OrdersStatusPay' => ['-f', '-c', '-e订单支付'],
        'shop/OrdersStatusRefund' => ['-f', '-c', '-e订单退款'],
        'shop/GoodsDiscounts' => ['-f', '-r', '-e优惠分类'],
    ];

    protected function configure()
    {
        $this->setName('auto')->setDescription('按照配置文件自动生成所有rest接口');
    }

    /**
     * 主体
     *
     * @param Input $input
     * @param Output $output
     * @return void
     */
    protected function execute(Input $input, Output $output)
    {
        foreach($this->config as $k => $v){
            $command = 'php think rest ' .$k . ' ' . implode(' ', $v);
            system( $command); 
        }
    }
}