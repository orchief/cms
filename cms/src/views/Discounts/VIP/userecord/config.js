const structure = {
    selectWait: [{
            url: 'admin/GoodsBrand',
            option: {
                value: 'id',
                label: 'brandName'
            },
            commitField: 'brandId'
        },
        {
            url: 'admin/GoodsCategories',
            option: {
                value: 'id',
                label: 'categoryName'
            },
            commitField: 'categoryId'
        }
    ],
    defaultSelectData: {
        enabled: [
            { label: '可用', value: '1' },
            { label: '冻结', value: '0' }
        ]
    },
    filterData: [{
        originField: 'status',
        showField: 'status',
        exchange: [{
                origin: 0,
                show: '冻结'
            },
            {
                origin: 1,
                show: '可用'
            }
        ]
    }],
    fields: {
        id: {
            desc: 'VIP卡id'
        },
        username: {
            desc: '用户名字'
        },
        productName: {
            desc: '所属类型'
        },

        cardNumber: {
            desc: '卡号'
        },
        backgroundImg: {
            desc: '背景图'
        },
        title: {
            desc: '标题'
        },
        desc: {
            desc: '副标题'
        },
        startDate: {
            desc: '购买时间'
        },
        endDate: {
            desc: '结束时间'
        },
        payment: {
            desc: '价格'
        },
        remark: {
            desc: '描述'
        },
        orderId: {
            desc: '发放卡的订单号'
        },
        createTime: {
            desc: '领取时间'
        },
        status: {
            desc: '状态'
        },
        period: {
            desc: '有效期'
        }
    },
    baseApi: 'admin/MembersVip',
    excel: {
        fileName: '用户列表',
        fields: [
            'cardNumber', 'productName', 'username', 'createTime', 'endDate', 'status'
        ]
    },
    search: {
        input: {
            fields: ['title', 'desc']
        }

    },
    table: {
        sort: {
            fields: [

            ]
        },
        show: {
            fields: [
                'cardNumber', 'productName', 'username', 'createTime', 'period', 'status'
            ],
            width: [200, 100, 100]
        },
        hidden: {
            fields: [
                'payment', 'remark', 'createTime', 'backgroundImg', 'orderId', 'title'
            ]
        },
        batch: {
            buttons: [{
                    title: '启用',
                    loading: 'enableLoading',
                    size: 'small',
                    param: 1,
                    type: 'status',
                    word: '启用成功!'
                },
                {
                    title: '禁用',
                    loading: 'enableLoading',
                    size: 'small',
                    param: 0,
                    type: 'status',
                    word: '禁用成功!'
                }
            ]
        }
    },
    add: {
        title: '新增代理',
        show: false,
        form: {
            input: [
                { prop: 'level1', label: '一阶分成比率', sort: 1 },
                { prop: 'level2', label: '二阶分成比率', sort: 1 },
            ],
            select: [],
            uploadImg: []
        },
        rules: {}
    },
    edit: {
        title: '编辑',
        form: {
            input: [
                { prop: 'level1', label: '一阶分成比率', sort: 1 },
                { prop: 'level2', label: '二阶分成比率', sort: 1 }
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