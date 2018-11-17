const structure = {
    baseApi: 'admin/goodscategories', // 基础接口地址
    fields: { // 所有涉及到的字段和字段注释
        id: {
            desc: '类别id'
        },
        bigImageUrl: {
            desc: '类别图片'
        },
        pid: {
            desc: '父id'
        },
        categoryName: {
            desc: '类别名称'
        },
        icon: {
            desc: '类别图标'
        },
        special:{
            desc: '是否为特殊分类'
        },
        isShow:{
            desc: '是否显示'
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
        fileName: '商品分类列表', // 导出excel文件名称
        fields: [ // 导出字段 (范围必须在fields里边)
            'id',
            'bigImageUrl',
            'pid',
            'categoryName',
            'icon',
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
                'id',
                'pid',
                'categoryName',
                
            ],
            width: []
        },
        hidden: { // 隐藏字段
            fields: [
                'bigImageUrl',
                'icon',
            ]
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
        title: '新增',
        show: true,
        form: [
            { prop: 'pid', label: '上级分类', type: 'select' },
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
            { prop: 'pid', label: '上级分类', type: 'select' },
            { prop: 'categoryName', label: '分类名', type: 'input' },
            { 
                prop: 'special',
                label: '是否为特殊分类', 
                type: 'select',
                default:[
                    {label:'是',value:1},{label:'否',value:0}
                ]
             },
             {
                prop: 'isShow',
                label: '是否显示',
                type: 'select',
                default: [
                    { label: '是', value: 1 }, { label: '否', value: 0 }
                ] 
            },
            { prop: 'bigImageUrl', label: '分类图片', type: 'img' },
            { prop: 'icon', label: '分类icon', type: 'input' },
        ],
        rules: {}
    }
}

export default structure