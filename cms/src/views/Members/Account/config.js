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
    filterData: [{
        originField: 'type',
        showField: 'typeTitle',
        exchange: [{
                origin: 1,
                show: '余额'
            },
            {
                origin: 2,
                show: '积分'
            },
            {
                origin: 3,
                show: '佣金'
            },
            {
                origin: 4,
                show: '支付宝'
            },
            {
                origin: 5,
                show: '微信'
            },
        ]
    }],

    fields: {
        change: {
            desc: '余额变动'
        },
        createTime: {
            desc: '时间'
        },
        username: {
            desc: '用户名'
        },
        typeTitle: {
            desc: '类型'
        },
        type: {
            desc: '类型'
        },
        remark: {
            desc: '详情'
        }
    },
    baseApi: 'admin/MembersAccount',
    excel: {
        fileName: '收支列表',
        fields: [
            'change', 'createTime', 'username', 'typeTitle', 'remark'
        ]
    },
    search: {
        input: {
            fields: ['username']
        },
        select: {
            fields: ['type']
        }
    },
    table: {
        sort: {
            fields: [
                'createTime'
            ]
        },
        show: {
            fields: [
                'username', 'change', 'createTime', 'typeTitle', 'remark'
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