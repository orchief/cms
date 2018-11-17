const structure = {
    selectWait: [],
    defaultSelectData: {
        type: [
            { label: '余额', value: '1' },
            { label: '积分', value: '2' },
            { label: '佣金', value: '3' },
            { label: '支付宝', value: '4' },
            { label: '微信', value: '5' }
        ]
    },
    filterData: [],
    fields: {
        id: {
            desc: '订单号'
        },
        originTotal: {
            desc: '订单原价'
        },
        payment: {
            desc: '实付价'
        },
        shippingPrice: {
            desc: '运费'
        },
        createDate: {
            desc: '下单时间'
        },
        isResource: {
            desc: '订单类型'
        }
    },
    baseApi: 'admin/Orders',
    excel: {
        fileName: '订单列表',
        fields: [
            'id', 'originTotal', 'payment', 'shippingPrice', 'createDate', 
        ]
    },
    search: {
        input: {
            fields: ['id', 'originTotal', 'payment', 'shippingPrice', ]
        },
        select: {
            fields: []
        }
    },
    table: {
        sort: {
            fields: []
        },
        show: {
            fields: [
                'id', 'originTotal', 'payment', 'shippingPrice', 'createDate', 
            ],
            width: [100, 200, 300]
        },
        hidden: {
            fields: [
                // 'username', 'enabled'
            ]
        },
        batch: {
            buttons: []
        },
        operator: {
            del: false,
            edit: false,
            link: [
                {
                  name: "订单详情",
                  title: "订单详情",
                  class: "ordersItems",
                  svg: true
                },
                {
                    name: "物流详情",
                    title: "物流详情",
                    class: "logistics",
                    svg: true
                  }
              ]
        }
    },
    add: {
        title: '新增',
        show: false,
        form: {
            input: [],
            select: [],
            uploadImg: []
        },
        rules: {}
    },
    edit: {
        title: '编辑',
        show: true,
        form: {
            input: [
                { prop: 'Code', label: '用户短信验证码(最大支持8位)', sort: 1 },
                { prop: 'Password', label: '密码', sort: 1 },
            ],
            select: [],
            uploadImg: []
        },
        rules: {
            Password: [{ required: true, message: '请输入密码' }],
            PasswordSalt: [{ required: true, message: '请输入登录密码盐' }],
        }
    }
}

export default structure