const structure = {
    baseApi: 'admin/ordersitemsgoods', // 基础接口地址
    fields: { // 所有涉及到的字段和字段注释
        orderId: {
            desc: '订单号'
        },
        quantity: {
            desc: '商品数量'
        },
        salePrice: {
            desc: '商品售价'
        },
        productName: {
            desc: '商品名'
        },
        createDate: {
            desc: '下单时间'
        },
        isResource: {
            desc: '订单类型'
        }
    },
    defaultSelectDataApi: [
        // {
        //     url: 'admin/expresscompany', // 接口地址
        //     option: {
        //         value: 'id',         // 获取值
        //         label: 'companyName'   // 选项标题
        //     },
        //     commitField: 'companyName'   // 对应字段
        // }
    ], //  源自接口的select选项默认数据
    defaultSelectData: {}, //  各位置select选项默认数据
    filterData: [
    //     { // 字段定向过滤
    //     originField: 'status', // 原始字段名称
    //     showField: 'statusTitle', // 新增字段名称
    //     exchange: [{
    //             origin: 0, // 原始字段值
    //             show: '冻结' // 转换值
    //         },
    //         {
    //             origin: 1,
    //             show: '激活'
    //         }
    //     ]
    // }
],
    excel: { // 导出excel配置信息
        fileName: '待发货订单', // 导出excel文件名称
        fields: [ // 导出字段 (范围必须在fields里边)
            'orderId', 'quantity', 'salePrice', 'productName', 'createDate',
        ]
    },
    search: [
        { type: 'input', prop: 'title' }
    ],
    table: {
        sort: {
            fields: []
        },
        show: {
            fields: [
                'orderId', 'quantity', 'salePrice', 'productName', 
            ],
            width: []
        },
        hidden: { // 隐藏字段
            fields: [
            ]
        },
        batch: { // 批量操作
            buttons: []
        },
        // operator: {
        //     del: false,
        //     edit: true,
        //     link: [
        //         {
        //           name: "订单详情",
        //           title: "订单详情",
        //           class: "ordersItems",
        //           svg: true
        //         }
        //       ]
        // }
    },
    add: {
        title: '新增',
        show: false,
        form: [
            { prop: 'categoryName', label: '分类名', type: 'input' },
            { 
                prop: 'special',
                label: '是否为特殊分类', 
                type: 'select',
                default:[
                    {label:'是',value:'1'},{label:'否',value:'0'}
                ]
             },
            {
                prop: 'isShow',
                label: '是否显示',
                type: 'select',
                default: [
                    { label: '是', value: '1' }, { label: '否', value: '0' }
                ]
            },
            { prop: 'bigImageUrl', label: '分类图片', type: 'img' },
            { prop: 'icon', label: '分类icon', type: 'input' },
        ],
        rules: {}
    },
    edit: {
        title: '编辑',
        show: true,
        form: [
            { prop: 'expressNum', label: '物流单号', type: 'input' },
            { 
                prop: 'companyName',
                label: '物流公司', 
                type: 'select',
             },
        ],
        rules: {}
    }
}

export default structure