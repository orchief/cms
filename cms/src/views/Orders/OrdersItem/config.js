const structure = {
    selectWait: [],
    defaultSelectData: {
        type: [
            { label: '通过', value: '1' },
            { label: '拒绝', value: '2' }
        ]
    },
    filterData: [],
    fields: {
        orderId: {
            desc: '订单号'
        },
        username: {
            desc: '用户姓名'
        },
        phone: {
            desc: '用户电话'
        },
        money: {
            desc: '退款金额'
        },
        reason: {
            desc: '取消原因'
        },
        createDate: {
            desc: '创建时间'
        },
    },
    baseApi: 'admin/ordersstatusrefund',
    excel: {
        fileName: '退款申请',
        fields: [
            'orderId', 'username', 'phone', 'money', 'reason', 'createDate'
        ]
    },
    search: {
        input: {
            fields: ['orderId', 'username', 'phone']
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
                'orderId', 'username', 'phone', 'money', 'reason', 'createDate'
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
        show:false,
        form: {
            input: [
            ],
            select: [
                { prop: 'type', label: '操作', sort: 1 }
            ],
            uploadImg: []
        },
        rules: {
        }
    }
}

export default structure