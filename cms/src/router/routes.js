import Members from '../views/Members/Members'
import Account from '../views/Members/Account'
import Address from '../views/Members/Address'
import Banks from '../views/Members/Banks'
import Apply from '../views/Members/Apply'
import Cashes from '../views/Members/Cashes'
import Comments from '../views/Members/Comments'

// 订单
import Orders from '../views/Orders/Orders'
import received from '../views/Orders/Orders/Received/'
import payed from '../views/Orders/Orders/Payed/'
import info from '../views/Orders/Orders/info/'
import expressInfo from '../views/Orders/Orders/expressInfo/'
import OrdersItems from '../views/Orders/OrdersItems'
import OrdersItem from '../views/Orders/OrdersItem'

// 商品
import brand from '../views/Goods/brand'
import category from '../views/Goods/Category'
import products from '../views/Goods/product'
import skus from '../views/Goods/Skus'
import skusadd from '../views/Goods/Skusadd'
import skusedit from '../views/Goods/skusedit'
import goodsadd from '../views/Goods/goodsadd'
import goodsedit from '../views/Goods/goodsedit'
import goodsrefer from '../views/Goods/goodsrefer'
import attru from '../views/Goods/attru'
// 促销 
import vouchers from '../views/Discounts/vouchers'
import vouchersfinished from '../views/Discounts/vouchers/finished'
import vouchersrecord from '../views/Discounts/vouchers/record'
import voucherssend from '../views/Discounts/vouchers/send'
// 砍价
import cut from '../views/Discounts/cut'
import cutStart from '../views/Discounts/cut/started.vue'
import cutUnstart from '../views/Discounts/cut/unstart.vue'
import cutClose from '../views/Discounts/cut/close.vue'

import pointevent from '../views/Discounts/point/event'
import VIP from '../views/Discounts/VIP'
import VIPuserecord from '../views/Discounts/VIP/userecord'
import vipProducts from '../views/Goods/vipProducts'
import vipProductsAdd from '../views/Goods/vipProducts'

// 分销 
import agent from '../views/Interest/agent'
import setting from '../views/Interest/setting'

// 设置
import logisticsTemplate from '../views/Setting/logistics/template' //运费模板
import logisticsAdd from '../views/Setting/logistics/addTemplate' //新增运费模板
import logisticsEdit from '../views/Setting/logistics/editTemplate' //修改运费模板
import logistics from '../views/Setting/logistics'
import logisticsCompany from '../views/Setting/logistics/company'
import area from '../views/Setting/area'
import wechatpay from '../views/Setting/wechat/pay'
import wechatpublic from '../views/Setting/wechat/public'
import noticeevent from '../views/Setting/notice/event'
import noticesms from '../views/Setting/notice/sms'
import about from '../views/Setting/about'
import banners from '../views/Setting/banners'

import Home from '../views/layout/Home.vue'

// 测试
import Goodstest from '../views/Goods/test'

const userdefineRoutes = [{
        path: '/cms/Members',
        component: Home,
        name: '会员',
        meta: { moduleName: '会员管理' },
        children: [{
                path: 'Members/list',
                component: Members,
                name: '会员列表',
                meta: {
                    hideLeft: false,
                    module: 'Members',
                }
            },
            {
                path: 'Account/:id',
                component: Account,
                name: '当前用户收支列表',
                meta: {
                    hideLeft: false,
                    module: 'Members',
                }
            }, {
                path: 'Account',
                component: Account,
                name: '收支列表',
                meta: {
                    hideLeft: false,
                    module: 'Members',
                }
            }, {
                path: 'Address/:id',
                component: Members,
                name: '当前用户地址管理',
                meta: {
                    hideLeft: false,
                    module: 'Address',
                }
            }, {
                path: 'Address',
                component: Address,
                name: '地址管理',
                meta: {
                    hideLeft: false,
                    module: 'Members',
                }
            }, {
                path: 'Bank/:id',
                component: Banks,
                name: '当前用户银行卡列表',
                meta: {
                    hideLeft: false,
                    module: 'Members',
                }
            }, {
                path: 'Bank',
                component: Banks,
                name: '银行卡列表',
                meta: {
                    hideLeft: false,
                    module: 'Members',
                }
            }, {
                path: 'Apply',
                component: Apply,
                name: '推广员列表',
                meta: {
                    hideLeft: false,
                    module: 'Members',
                }
            }, {
                path: 'Members/list',
                component: Members,
                name: '人脉列表',
                meta: {
                    hideLeft: false,
                    module: 'Members',
                }
            }, {
                path: 'Comments',
                component: Comments,
                name: '评论列表',
                meta: {
                    hideLeft: false,
                    module: 'Members',
                }
            }, {
                path: 'Cashes',
                component: Cashes,
                name: '提现列表',
                meta: {
                    hideLeft: false,
                    module: 'Members',
                }
            },
            {
                path: 'Cashes/:id',
                component: Cashes,
                name: '当前用户提现列表',
                meta: {
                    hideLeft: false,
                    module: 'Members',
                }
            }
        ]
    },
    {
        path: '/cms/Orders',
        component: Home,
        name: '订单',
        meta: { moduleName: '订单管理' },
        children: [{
                path: 'list/0',
                component: Orders,
                name: '待付款',
                meta: {
                    hideLeft: false,
                    module: 'Orders',
                }
            },
            {
                path: 'list/2',
                component: payed,
                name: '待发货',
                meta: {
                    hideLeft: false,
                    module: 'Orders',
                }
            }, {
                path: 'list/3',
                component: received,
                name: '待签收',
                meta: {
                    hideLeft: false,
                    module: 'Orders',
                }
            }, {
                path: 'list/4',
                component: Orders,
                name: '已完成',
                meta: {
                    hideLeft: false,
                    module: 'Orders',
                }
            }, {
                path: 'list/:id',
                component: info,
                name: '订单详情',
                meta: {
                    hideLeft: false,
                    module: 'Orders',
                }
            }, {
                path: 'info/:id',
                component: expressInfo,
                name: '物流详情',
                meta: {
                    hideLeft: false,
                    module: 'Orders',
                }
            }
        ]
    },
    {
        path: '/cms/OrdersItems',
        component: Home,
        name: '售后管理',
        meta: { moduleName: '订单' },
        children: [{
            path: 'list/6',
            component: OrdersItems,
            name: '售后订单',
            meta: {
                hideLeft: false,
                module: 'Orders',
            }
        }, {
            path: 'list/7',
            component: OrdersItem,
            name: '已处理订单',
            meta: {
                hideLeft: false,
                module: 'Orders',
            }
        }]
    },
    {
        path: '/cms/Goods',
        component: Home,
        name: '商品',
        meta: { moduleName: '商品管理' },
        children: [{
                path: 'test',
                component: Goodstest,
                name: '测试',
                meta: {
                    hideLeft: false,
                    module: 'Goods',
                }
            },{
                path: 'brand',
                component: brand,
                name: '品牌管理',
                meta: {
                    hideLeft: false,
                    module: 'Goods',
                }
            },
            {
                path: 'category',
                component: category,
                name: '分类管理',
                meta: {
                    hideLeft: false,
                    module: 'Goods',
                }
            }, {
                path: 'products',
                component: products,
                name: '产品管理',
                meta: {
                    hideLeft: false,
                    module: 'Goods',
                }
            },
            {
                path: 'goodsrefer',
                component: goodsrefer,
                name: '推荐管理',
                meta: {
                    hideLeft: false,
                    module: 'Goods',
                }
            },
            {
                path: 'classify',
                component: skus,
                name: '商品类型',
                meta: {
                    hideLeft: false,
                    module: 'Goods',
                }
            }, {
                path: 'skusadd',
                component: skusadd,
                name: '新增商品类型',
                meta: {
                    hideLeft: false,
                    module: 'Goods',
                }
            }, {
                path: 'skusedit',
                component: skusedit,
                name: '编辑商品类型',
                meta: {
                    hideLeft: false,
                    module: 'Goods',
                }
            }, {
                path: 'attru',
                component: attru,
                name: '新增规格值',
                meta: {
                    hideLeft: false,
                    module: 'Goods',
                }
            }, {
                path: 'add',
                component: goodsadd,
                name: '新增商品',
                meta: {
                    hideLeft: false,
                    module: 'Goods',
                },
            },
            {
                path: 'edit',
                component: goodsedit,
                name: '修改商品',
                meta: {
                    hideLeft: false,
                    module: 'Goods',
                }

            }
        ]
    },
    {
        path: '/cms/Discounts',
        component: Home,
        name: '促销',
        meta: { moduleName: '促销管理' },
        children: [{
                path: 'vouchers',
                component: vouchers,
                name: '优惠券管理',
                meta: {
                    hideLeft: false,
                    module: 'Discounts',
                }
            },
            {
                path: 'vouchersfinished',
                component: vouchersfinished,
                name: '已结束优惠券',
                meta: {
                    hideLeft: false,
                    module: 'Discounts',
                }
            },
            {
                path: 'vouchersrecord',
                component: vouchersrecord,
                name: '使用领取记录',
                meta: {
                    hideLeft: false,
                    module: 'Discounts',
                }
            },
            {
                path: 'vouchers/send',
                component: voucherssend,
                name: '手动发放',
                meta: {
                    hideLeft: false,
                    module: 'Discounts',
                }
            },
            {
                path: 'cut',
                component: cut,
                name: '好友砍价',
                meta: {
                    hideLeft: false,
                    module: 'Discounts',
                }
            },
            {
                path: 'cutStart',
                component: cutStart,
                name: '砍价进行中',
                meta: {
                    hideLeft: false,
                    module: 'Discounts',
                }
            },
            {
                path: 'cutUnstart',
                component: cutUnstart,
                name: '砍价未开始',
                meta: {
                    hideLeft: false,
                    module: 'Discounts',
                }
            },
            {
                path: 'cutClose',
                component: cutClose,
                name: '砍价已结束',
                meta: {
                    hideLeft: false,
                    module: 'Discounts',
                }
            },

            {
                path: 'point/event',
                component: pointevent,
                name: '积分赠送管理',
                meta: {
                    hideLeft: false,
                    module: 'Discounts',
                }
            },
            {
                path: 'VIPs',
                component: VIP,
                name: 'VIP分类',
                meta: {
                    hideLeft: false,
                    module: 'Discounts',
                }
            },
            {
                path: 'VIP/userecord',
                component: VIPuserecord,
                name: 'VIP卡管理',
                meta: {
                    hideLeft: false,
                    module: 'Discounts',
                }
            }, {
                path: 'products/:id',
                component: vipProducts,
                name: 'vip卡商品列表',
                meta: {
                    hideLeft: false,
                    module: 'Discounts',
                }
            },
            {
                path: 'addproducts/:id',
                component: vipProductsAdd,
                name: 'vip卡商品新增',
                meta: {
                    hideLeft: false,
                    module: 'Discounts',
                }
            }
        ]
    },
    {
        path: '/cms/Interest',
        component: Home,
        name: '分销',
        meta: { moduleName: '分销管理' },
        children: [{
                path: 'agent',
                component: agent,
                name: '分销商管理',
                meta: {
                    hideLeft: false,
                    module: 'Interest',
                }
            },
            {
                path: 'setting',
                component: setting,
                name: '',
                meta: {
                    hideLeft: false,
                    module: 'Interest',
                }
            }
        ]
    },
    {
        path: '/cms/Setting',
        component: Home,
        name: '设置',
        meta: { moduleName: '设置管理' },
        children: [{
                path: 'logistics/area',
                component: area,
                name: '物流覆盖',
                meta: {
                    hideLeft: false,
                    module: 'Setting',
                }
            },
            {
                path: 'logistics/template',
                component: logisticsTemplate,
                name: '物流模板',
                meta: {
                    hideLeft: false,
                    module: 'Setting',
                }
            },
            {
                path: 'logistics/add',
                component: logisticsAdd,
                name: '物流模板新增',
                meta: {
                    hideLeft: false,
                    module: 'Setting',
                }
            },
            {
                path: 'logistics/edit',
                component: logisticsEdit,
                name: '修改模板',
                meta: {
                    hideLeft: false,
                    module: 'Setting',
                }
            },
            {
                path: 'logistics/company',
                component: logisticsCompany,
                name: '物流公司',
                meta: {
                    hideLeft: false,
                    module: 'Setting',
                }
            },
            {
                path: 'logistics',
                component: logistics,
                name: '快递100配置信息',
                meta: {
                    hideLeft: false,
                    module: 'Setting',
                }
            },
            {
                path: 'wechat/pay',
                component: wechatpay,
                name: '支付',
                meta: {
                    hideLeft: false,
                    module: 'Setting',
                }
            },
            {
                path: 'wechat/public',
                component: wechatpublic,
                name: '公众号',
                meta: {
                    hideLeft: false,
                    module: 'Setting',
                }
            },
            {
                path: 'notice/event',
                component: noticeevent,
                name: '事件列表',
                meta: {
                    hideLeft: false,
                    module: 'Setting',
                }
            },
            {
                path: 'banners/list',
                component: banners,
                name: '轮播列表',
                meta: {
                    hideLeft: false,
                    module: 'Setting',
                }
            },
            {
                path: 'notice/sms',
                component: noticesms,
                name: '短信设置',
                meta: {
                    hideLeft: false,
                    module: 'Setting',
                }
            },
            {
                path: 'about',
                component: about,
                name: '信息设置',
                meta: {
                    hideLeft: false,
                    module: 'Setting',
                }
            }

        ]
    }
]























// 两部分路由合并处理
import baseRoutes from './base.js'
const routes = userdefineRoutes.concat(baseRoutes)
export default routes