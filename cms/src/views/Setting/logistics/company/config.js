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
        companyName: {
            desc: '物流公司'
        },
        kuaidi100Code: {
            desc: '快递100Code'
        },
    },
    baseApi: 'admin/ExpressCompany',
    excel: {
        fileName: '物流公司列表',
        fields: [
            'companyName', 'kuaidi100Code'
        ]
    },
    search: {
        input: {
            fields: ['companyName', 'kuaidi100Code']
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
                'companyName', 'kuaidi100Code'
            ],
            type: ['string', 'string', 'string', 'img', 'string'],
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
            edit: true,
            del: true
        }
    },
    add: {
        title: '新增',
        show: true,
        form: {
            input: [
                { prop: 'companyName', label: '物流公司', sort: 1 },
                { prop: 'kuaidi100Code', label: '快递100Code', sort: 1 },
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
                { prop: 'companyName', label: '物流公司', sort: 1 },
                { prop: 'kuaidi100Code', label: '快递100Code', sort: 1 },
            ],
            select: [],
            uploadImg: []
        },
        rules: {

        }
    }
}

export default structure