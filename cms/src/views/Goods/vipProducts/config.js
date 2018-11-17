const structure = {
    baseApi: 'admin/VipProducts', // 基础接口地址
    fields: { // 所有涉及到的字段和字段注释
        onSale: {
            desc: '是否在售'
        },
        sortBy: {
            desc: '排序'
        },
        marketPrice: {
            desc: '市场价格'
        },
        salePrice: {
            desc: '销售价格'
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
            desc: '商品货号'
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
        },
         id: {
            desc: 'id'
        },
        quality: {
            desc: '商品数量'
        }
    },
    defaultSelectDataApi: [
        {
            url: 'admin/goodsproducts', // 接口地址
            option: {
                value: 'skuId',         // 获取值
                label: 'productName'   // 选项标题
            },
            commitField: 'productName'   // 对应字段
        }
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
            'productName',
            'productCode',
            'marketPrice',
            'salePrice',
            'title',
            'shortDescription',
            'unit',
            'quality',
        ]
    },
    search: [ // 搜索选项
        { type: 'input', prop: 'title' }
    ],
    defaultSearchConditions: { // 默认传输参数
        limit: 5,
        page: 1,
        isDelete: '0'
    },
    table: {
        sort: {
            fields: []
        },
        show: {
            fields: [
                'productName',
                'productCode',
                'marketPrice',
                'salePrice',
                'title',
                'shortDescription',
                'unit',
                'quality',
            ],
            width: []
        },
        hidden: { // 隐藏字段
            fields: []
        },
        batch: { // 批量操作
            buttons: [
            //     {
            //     title: '添加到vip卡',
            //     loading: 'enableLoading',
            //     size: 'small',
            //     param: 1,
            //     type: 'status'
            // }
        ]
        },
        operator: {
            del: true,
            edit: false,
            link: []
        }
    },
    add: {
        title: '新增商品',
        show: true,
        form: [{ prop: 'productName', label: '商品名称', type: 'select' },
            
            { prop: 'quality', label: '商品数量', type: 'input' },
        ],
        rules: {}
    },
    edit: {
        title: '编辑商品',
        show: false,
        form: [
            { prop: 'productName', label: '商品名称', type: 'input' },
            { prop: 'productCode', label: '商品货号', type: 'input' },
            { prop: 'title', label: '商品副标题', type: 'input' },
            { prop: 'marketPrice', label: '市场价格', type: 'input' },
            { prop: 'currentPrice', label: '当前售价', type: 'input' },
            { prop: 'unit', label: '计量单位', type: 'input' },
            { prop: 'shortDescription', label: '简介', type: 'input' },
            { prop: 'description', label: '详情', type: 'richtext' },
            { prop: 'imgPath', label: '商品logo', type: 'img' },
            {
                prop: 'onSale',
                label: '是否上架',
                type: 'select',
                default: [
                    { label: '上架', value: '1' }, { label: '不上架', value: '0' }
                ]
            }
        ],
        rules: {}
    }
}

export default structure