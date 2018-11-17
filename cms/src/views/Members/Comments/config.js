const structure = {
    selectWait: [],
    defaultSelectData: {
        isHidden: [
            { label: '正常显示', value: '0' },
            { label: '已屏蔽', value: '1' }
        ]
    },
    filterData: [{
        originField: 'isHidden',
        showField: 'isHidden',
        exchange: [{
                origin: 0,
                show: '显示'
            },
            {
                origin: 1,
                show: '隐藏'
            }
        ]
    }],
    fields: {
        orderId: {
            desc: '订单号'
        },
        productCode: {
            desc: '商品货号'
        },
        productName: {
            desc: '商品名称'
        },
        quantity: {
            desc: '购买数量'
        },
        shipmentQuantity: {
            desc: '发货数量'
        },
        salePrice: {
            desc: '购买价格'
        },
        skuContent: {
            desc: '商品规格详情'
        },
        weight: {
            desc: '商品单品重量'
        },
        isHidden: {
            desc: '是否被屏蔽'
        },
        reviewContent: {
            desc: '评论内容'
        },
        reviewDate: {
            desc: '评论时间'
        },
        reviewMark: {
            desc: '评论星级'
        },
        replyContent: {
            desc: '回复内容'
        },
        replyDate: {
            desc: '回复时间'
        }
    },

    // reviewContent
    // reviewDate
    // reviewMark
    // replyContent
    // replyDate


    baseApi: 'admin/MembersComments',
    excel: {
        fileName: '评论列表',
        fields: [
            'orderId', 'productCode', 'productName', 'quantity', 'shipmentQuantity', 'salePrice', 'skuContent', 'weight', 'isHidden'
        ]
    },
    search: {
        input: {
            fields: ['orderId', 'productCode', 'productName', 'quantity', 'shipmentQuantity', 'salePrice', 'skuContent', 'weight']
        },
        select: {
            fields: ['isHidden']
        }
    },
    table: {
        sort: {
            fields: []
        },
        show: {
            fields: [
                'orderId', 'reviewContent', 'reviewDate', 'reviewMark', 'replyContent', 'replyDate', 'isHidden'
            ],
            width: [100, 200, 300]
        },
        hidden: {
            fields: [
                'productCode', 'productName', 'quantity', 'shipmentQuantity', 'salePrice', 'skuContent', 'weight',
            ]
        },
        batch: {
            buttons: [{
                    title: '屏蔽评论',
                    loading: 'enableLoading',
                    size: 'small',
                    param: 1
                },
                {
                    title: '解禁评论',
                    loading: 'enableLoading',
                    size: 'small',
                    param: 0
                }
            ]
        },
        operator: null
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
        form: {
            input: [
                { prop: 'Code', label: '用户短信验证码(最大支持8位)', sort: 1 },
                { prop: 'Password', label: '密码', sort: 1 },
                { prop: 'PasswordSalt', label: '登录密码盐', sort: 1 },
                { prop: 'TradePassword', label: '交易密码', sort: 1 },
                { prop: 'UserName', label: '用户名', sort: 1 },
                { prop: 'BirchDate', label: '生日', sort: 1 },
                { prop: 'RealName', label: '真实姓名', sort: 1 },
                { prop: 'IdCard', label: '身份证号', sort: 1 },
                { prop: 'Email', label: '邮箱', sort: 1 },
                { prop: 'CellPhone', label: '手机号', sort: 1 },
                { prop: 'QQ', label: 'qq号', sort: 1 },
                { prop: 'WeChat', label: '微信号', sort: 1 },
                { prop: 'OpenId', label: '用户微信openid', sort: 1 }
            ],
            select: [],
            uploadImg: []
        },
        rules: {
            Password: [{ required: true, message: '请输入密码' }],
            PasswordSalt: [{ required: true, message: '请输入登录密码盐' }],
            TradePassword: [{ required: true, message: '请输入交易密码' }],
            UserName: [{ required: true, message: '请输入用户名' }],
            RealName: [{ required: true, message: '请输入真实姓名' }],
            IdCard: [{ required: true, message: '请输入身份证号' }],
            Email: [{ required: true, message: '请输入邮箱' }],
            CellPhone: [{ required: true, message: '请输入手机号' }],
            QQ: [{ required: true, message: '请输入qq号' }],
            WeChat: [{ required: true, message: '请输入微信号' }],
            OpenId: [{ required: true, message: '请输入用户微信openid' }]
        }
    }
}

export default structure