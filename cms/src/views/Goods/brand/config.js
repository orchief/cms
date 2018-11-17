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
        brandName: {
            desc: '品牌名称',
            type: 'string'
        },
        companyUrl: {
            desc: '品牌网址',
            type: 'string'
        },
        description: {
            desc: '描述',
            type: 'string'
        },
        logo: {
            desc: 'logo',
            type: 'img'
        },
        sortBy: {
            desc: '排序',
            type: 'string'
        }
    },
    baseApi: 'admin/GoodsBrand',
    excel: {
        fileName: '品牌列表',
        fields: [
            'brandName', 'companyUrl', 'description', 'logo', 'sortBy'
        ]
    },
    search: {
        input: {
            fields: ['brandName', 'companyUrl', 'description']
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
                'brandName', 'companyUrl', 'description', 'logo', 'sortBy'
            ],
            type: ['string', 'string', 'string', 'img', 'string'],
            width: [100, 200, 200, 220]
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
            edit: true,
            del: true
        }
    },
    add: {
        title: '新增',
        show: true,
        form: {
            input: [
                { prop: 'brandName', label: '品牌名称', sort: 1 },
                { prop: 'companyUrl', label: '品牌网址', sort: 1 },
                { prop: 'description', label: '描述', sort: 1 },
                { prop: 'sortBy', label: '排序', sort: 1 },
            ],
            select: [],
            uploadImg: [{ prop: 'logo', label: 'logo', sort: 1 }]
        },
        rules: {}
    },
    edit: {
        title: '编辑',
        form: {
            input: [
                { prop: 'brandName', label: '品牌名称', sort: 1 },
                { prop: 'companyUrl', label: '品牌网址', sort: 1 },
                { prop: 'description', label: '描述', sort: 1 },
                { prop: 'sortBy', label: '排序', sort: 1 },
            ],
            select: [],
            uploadImg: { prop: 'logo', label: 'logo', sort: 1 }
        },
        rules: {

        }
    }
}

export default structure