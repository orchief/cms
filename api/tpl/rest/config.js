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
        originField: 'enabled',
        showField: 'enabledTitle',
        exchange: [{
                origin: 0,
                show: '冻结'
            },
            {
                origin: 1,
                show: '可用2'
            }
        ]
    }],
    fields: {
        username: {
            desc: '用户名'
        },
        enabled: {
            desc: '用户状态'
        },
        phone: {
            desc: '手机号'
        },
        enabledTitle: {
            desc: '用户状态'
        }
    },
    baseApi: 'admin/Members',
    excel: {
        fileName: '用户列表',
        fields: [
            'username', 'enabledTitle', 'phone'
        ]
    },
    search: {
        input: {
            fields: ['username']
        },
        select: {
            fields: ['enabled']
        }
    },
    table: {
        sort: {
            fields: [
                'phone'
            ]
        },
        show: {
            fields: [
                'username', 'enabledTitle', 'phone'
            ],
            width: [100, 200, 300]
        },
        hidden: {
            fields: [
                'username', 'enabled'
            ]
        },
        batch: {
            buttons: [{
                    title: '解冻',
                    loading: 'enableLoading',
                    size: 'small',
                    param: 1
                },
                {
                    title: '冻结',
                    loading: 'disableLoading',
                    size: 'small',
                    param: 0
                }
            ]
        },
        operator: {
            del: false,
            edit: true,
            link: [{
                    name: '人脉列表',
                    title: '子用户管理',
                    class: 'directlyChild',
                    svg: true
                },
                {
                    name: '地址列表',
                    title: '地址',
                    class: 'address',
                    svg: true
                },
                {
                    name: '银行卡列表',
                    title: '银行卡',
                    class: 'bank',
                    svg: true
                },
                {
                    name: '收支列表',
                    title: '余额记录',
                    class: 'rewardRecord',
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