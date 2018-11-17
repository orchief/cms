const structure = {
    selectWait: [],
    defaultSelectData: {
        status: [
            { label: '审核中', value: '0' },
            { label: '审核通过', value: '1' },
            { label: '审核驳回', value: '2' },
        ]
    },
    filterData: [{
        originField: 'status',
        showField: 'status',
        exchange: [{
                    origin: 0,
                    show: '审核中'
                },
                {
                    origin: 1,
                    show: '审核通过'
                },
                {
                    origin: 2,
                    show: '审核驳回'
                }
            ]
            // 0 刚刚申请  1审核通过    2审核驳回
    }],
    fields: {
        username: {
            desc: '用户名'
        },
        phone: {
            desc: '手机号'
        },
        createDate: {
            desc: '注册时间'
        },
        interest: {
            desc: '账户佣金'
        },
        reason: {
            desc: '申请原因'
        },
        status: {
            desc: '状态'
        },
    
    },
    baseApi: 'admin/membersagentapply',
    excel: {
        fileName: '地址列表',
        fields: [
            'username', 'phone','createDate','interest','status'
        ]
    },
    search: {
        input: {
            fields: ['username',]
        },
        select: {
            fields: ['status']
        }
    },
    table: {
        sort: {
            fields: []
        },
        show: {
            fields: [
                'username','phone','createDate','interest','status'
            ],
            width: [100, 200, 300]
        },
        hidden: {
            fields: [
                // 'username', 'enabled'
            ]
        },
        batch: {
                buttons: [{
                    title: '批准',
                    loading: 'enableLoading',
                    size: 'small',
                    param: 1,
                    type:'status',
                    word:'批准成功!'
                },
                {
                    title: '驳回',
                    loading: 'enableLoading',
                    size: 'small',
                    param: 2,
                    type:'status',
                    word:'驳回成功!'
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