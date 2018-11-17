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
        valueStr: {
            desc: '规格值'
        },
        
    },
    baseApi: '/admin/GoodsAttributeValues',
    excel: {
        fileName: '地址列表',
        fields: [
            
        ]
    },
    search: {
        input: {
            fields: []
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
                'valueStr'
            ],
            type: ['string', 'string', 'string', 'img', 'string'],
            width: []
        },
        hidden: {
            fields: [
                // 'username', 'enabled'
            ]
        },
        batch: {
            buttons: [{
                title: '解冻',
                loading: 'enableLoading',
                size: 'small',
                param: 1,
                type: 'status',
            },
            ]
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
                { prop: 'valueStr', label: '规格值', sort: 1 },
            ],
            select: [],
        },
        rules: {
            valueStr: [{ required: true, message: '请输入规格值' }],
        }
    },
    edit: {
        title: '编辑',
        form: {
            input: [
                { prop: 'valueStr', label: '规格值', sort: 1 },
            ],
            select: [],
            uploadImg: []
        },
        rules: {
            valueStr: [{ required: true, message: '请输入规格值' }],
        }
    }
}

export default structure