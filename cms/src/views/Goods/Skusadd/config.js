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
        attributeName: {
            desc: '商品规格'
        },
    },
    baseApi: '/admin/GoodsAttribute',
    skubaseApi:'/admin/GoodsAttributeGroup',
    excel: {
        fileName: '地址列表',
        fields: [
            'attributeName'
        ]
    },
    search: {
        input: {
            fields: ['attributeName']
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
                'attributeName'
            ],
            width: []
        },
        hidden: {
            fields: [
            ]
        },
        batch: {
            buttons: []
        },
        operator: {
            del: true,
            edit: false,
            link: [{
                name: '新增规格值',
                title: '编辑',
                class: 'address',
                svg: true
            },
        ]
        },
        tag:{
           
        }
    },
    add: {
        title: '新增',
        show: true,
        form: {
            input: [
                { prop: 'attributeName', label: '商品规格名称', sort: 1 },
            ],
            select: [ { prop: 'attributeValues', label: '商品规格值', sort: 1 }],
            uploadImg: []
        },
        formsku: {
            input: [
                { prop: 'name', label: '商品类型名称', sort: 1 },
                { prop: 'desc', label: '商品类型描述', sort: 1 },
            ],
            select: [],
            uploadImg: []
        },
        rules: {
            name: [{ required: true, message: '请输入类型名称' }],
            desc: [{ required: true, message: '请输入类型描述' }],
            attributeName: [{ required: true, message: '请输入类型名称' }],
            attributeValues: [{ required: true, message: '请输入类型描述' }],
        }
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