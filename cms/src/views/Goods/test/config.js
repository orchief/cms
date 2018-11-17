const structure = {
    baseApi: 'admin/test', // 基础接口地址
    fields: {
        createDate: {
            desc: '创建时间'
        },
        content: {
            desc: '内容'
        },
        status: {
            desc: '状态'
        },
        statusTitle: {
            desc: '状态'
        },
        name: {
            desc: '名称'
        },
        phone: {
            desc: '手机号'
        }
    },
    defaultSelectDataApi: [], //  源自接口的select选项默认数据
    defaultSelectData: {}, //  各位置select选项默认数据
    filterData: [
        {
                              originField: 'status',
                              showField: 'statusTitle',
                              exchange: [
                                  {
                                    origin: 1, 
                                    show: ' 启用  '
                                },{
                                    origin: 0, 
                                    show: ' 禁用 '
                                }
                            ]
                          }
    ],
    excel: { // 导出excel配置信息
        fileName: '测试列表', // 导出excel文件名称
        fields: [ // 导出字段 (范围必须在fields里边)
"createDate","content","status","statusTitle","name","phone"
        ]
    },
    search: [ // 搜索选项
        { type: 'input', prop: 'createDate' },
        { type: 'input', prop: 'content' },
        { type: 'input', prop: 'status' },
        { type: 'input', prop: 'name' },
        { type: 'input', prop: 'phone' }
    ],
    defaultSearchConditions: { // 默认查询参数
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
                "createDate","content","status","statusTitle","name","phone"
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
            edit: true
        }
    },
    add: {
        title: '新增测试',
        show: true,
        form: [
                { prop: 'createDate', label: '创建时间', type: 'datetime' },
            { prop: 'content', label: '内容', type: 'input' },
                { prop: 'status', label: '状态', type: 'select' , default: [
                    { label: ' 启用  ', value: 1 },{ label: ' 禁用 ', value: 0 }
                ]},
            { prop: 'name', label: '名称', type: 'input' },
            { prop: 'phone', label: '手机号', type: 'input' }
        ],
        rules: {
            
        }
    },
    edit: {
        title: '编辑测试',
        show: true,
        form: [
                { prop: 'createDate', label: '创建时间', type: 'datetime' },
            { prop: 'content', label: '内容', type: 'input' },
                { prop: 'status', label: '状态', type: 'select' , default: [
                    { label: ' 启用  ', value: 1 },{ label: ' 禁用 ', value: 0 }
                ]},
            { prop: 'name', label: '名称', type: 'input' },
            { prop: 'phone', label: '手机号', type: 'input' }
        ],
        rules: {
            
        }
    }
}

export default structure