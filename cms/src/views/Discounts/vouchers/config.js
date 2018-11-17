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
        discountName: {
            desc: '优惠券名称'
        },
        denomination: {
            desc: '面值'
        },
        date: {
            desc: '使用期限'
        },
        discountLimit: {
            desc: '领取限制'
        },
        amount: {
            desc: '发放总量'
        }
    },
    baseApi: 'admin/GoodsDiscounts',
    // excel: {
    //     fileName: '地址列表',
    //     fields: [
    //         'brandName', 'companyUrl', 'description', 'logo', 'sortBy'
    //     ]
    // },
    search: {
        input: {
            fields: ['discountName']
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
                'discountName', 'denomination', 'date', 'discountLimit', 'amount'
            ],
            type: ['string', 'string', 'string', 'string', 'string'],
            width: [100, 200, 200, 200, 200]
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
            edit: false,
            del: true
        }
    },
    add: {
        title: '新增',
        show: true,
        form: {
            input: [
                { prop: 'discountName', label: '优惠劵名称', sort: 1 },
                { prop: 'denomination', label: '面值', sort: 1 },
                { prop: 'date', label: '使用期限', sort: 1 },
                { prop: 'discountLimit', label: '领取限制', sort: 1 },
                { prop: 'amount', label: '发放总量', sort: 1 },
            ],
            select: [],
        },
        rules: {}
    },
    edit: {
        title: '编辑',
        form: {
            input: [
                { prop: 'discountName', label: '优惠劵名称', sort: 1 },
                { prop: 'denomination', label: '面值', sort: 1 },
                { prop: 'date', label: '使用期限', sort: 1 },
                { prop: 'discountLimit', label: '领取限制', sort: 1 },
                { prop: 'amount', label: '发放总量', sort: 1 },
            ],
            select: [],
        },
        rules: {

        }
    }
}

export default structure