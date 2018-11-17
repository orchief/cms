const structure = {
    baseApi: 'admin/GoodsVipCard', // 基础接口地址
    fields: { // 所有涉及到的字段和字段注释
        imgPath: {
            desc: '背景图'
        },
        startDate: {
            desc: '开始时间'
        },
        endDate: {
            desc: '截止时间'
        },
        title: {
            desc: '标题'
        },
        shortDescription: {
            desc: '副标题'
        },
        description: {
            desc: '销售详情'
        },
        mobbileDescription: {
            desc: '售后详情'
        },
        onSale: {
            desc: '是否在售'
        },
        sortBy: {
            desc: '排序'
        },
        marketPrice: {
            desc: '市场价格'
        },
        currentPrice: {
            desc: '当前价格'
        },
        imgPath: {
            desc: '副标题'
        },
        addedDate: {
            desc: '上架时间'
        },
        unit: {
            desc: '单位'
        },
        productName: {
            desc: '商品名称'
        },
        productCode: {
            desc: '商品代码'
        },
        shortDescription: {
            desc: '商品简介'
        },
        description: {
            desc: '商品详情'
        },
        shipTemplateId: {
            desc: '物流模板'
        },
        onSaleTitle: {
            desc: '是否在售'
        },
        title: {
            desc: '副标题'
        }
    },
    defaultSelectDataApi: [
        // {
        //     url: 'admin/GoodsBrand', // 接口地址
        //     option: {
        //         value: 'id',         // 获取值
        //         label: 'brandName'   // 选项标题
        //     },
        //     commitField: 'brandId'   // 对应字段
        // }
    ], //  源自接口的select选项默认数据
    defaultSelectData: {}, //  各位置select选项默认数据
    filterData: [{ // 字段定向过滤
        originField: 'status', // 原始字段名称
        showField: 'statusTitle', // 新增字段名称
        exchange: [{
                origin: 0, // 原始字段值
                show: '冻结' // 转换值
            },
            {
                origin: 1,
                show: '激活'
            }
        ]
    }],
    excel: { // 导出excel配置信息
        fileName: 'VIP卡列表', // 导出excel文件名称
        fields: [ // 导出字段 (范围必须在fields里边)
            'imgPath',
            'startDate',
            'endDate',
            'title',
            'shortDescription',
            'description',
            'mobbileDescription',
            'unit',
            'productName',
            'productCode'
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
                'productName',
                'productCode',
                'title',
                'shortDescription',
                'description',
                'unit',
            ],
            width: []
        },
        hidden: { // 隐藏字段
            fields: []
        },
        batch: { // 批量操作
            buttons: []
        },
        operator: {
            del: true,
            edit: true,
            link: []
        }
    },
    add: {
        title: '新增商品',
        show: true,
        form: [
            { prop: 'productName', label: '商品名称', type: 'input' },
            { prop: 'title', label: '商品副标题', type: 'input' },
            { prop: 'shortDescription', label: '简介', type: 'input' },
            { prop: 'description', label: '详情', type: 'richtext' },
            {
                prop: 'onSale',
                label: '是否上架',
                type: 'select',
                default: [
                    { label: '上架', value: '1' }, { label: '不上架', value: '0' }
                ]
            },
            { prop: 'imgPath', label: '商品logo', type: 'img' }
        ],
        rules: {}
    },
    edit: {
        title: '编辑商品',
        show: true,
        form: [
            { prop: 'productName', label: '商品名称', type: 'input' },
            { prop: 'title', label: '商品副标题', type: 'input' },
            { prop: 'shortDescription', label: '简介', type: 'input' },
            { prop: 'description', label: '详情', type: 'richtext' },
            {
                prop: 'onSale',
                label: '是否上架',
                type: 'select',
                default: [
                    { label: '上架', value: '1' }, { label: '不上架', value: '0' }
                ]
            },
            { prop: 'imgPath', label: '商品logo', type: 'img' }
        ],
        rules: {}
    }
}

export default structure