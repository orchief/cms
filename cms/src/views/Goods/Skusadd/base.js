// 为了实现功能的基础配置
import config from 'src/config.js'
import structure from './config.js';

const configs = {
    Add: null,
    Edit: null,
    Config: null,
    Data: null
}


// 获取form容器
let addForm = {}
let formTypeArr = ['input', 'select', 'uploadImg']
formTypeArr.map(function(i) {
    for (let index = 0; index < (structure.add.form[i]).length; index++) {
        addForm[structure.add.form[i][index].prop] = null;
    }
})
let addFormsku = {}
let formTypeskuArr = ['input', 'select', 'uploadImg']
formTypeskuArr.map(function(i) {
    for (let index = 0; index < (structure.add.formsku[i]).length; index++) {
        addFormsku[structure.add.formsku[i][index].prop] = null;
    }
})
// 新怎页面配置
configs.Add = {
    show: structure.add.show,
    dialogFormVisible: false,
    data: {
        primary: '',
        form: addForm,
        formsku:addFormsku,
        selectData: structure.defaultSelectData
    },
    config: {
        uploadUrl: config.axios.defaults.baseURL + 'admin/upload',
        domain: config.axios.defaults.baseURL,
        title: structure.add.title,
        form: structure.add.form,
        formsku: structure.add.formsku,
        rules: structure.add.rules
    }
}


// 编辑页面配置
let editForm = {}
formTypeArr.map(function(i) {
    for (let index = 0; index < (structure.edit.form[i]).length; index++) {
        editForm[structure.edit.form[i][index].prop] = null;
    }
})

configs.Edit = {
    dialogFormVisible: false,
    data: {
        primary: '',
        form: editForm,
        selectData: structure.defaultSelectData
    },
    config: {
        uploadUrl: config.axios.defaults.baseURL + 'admin/upload',
        domain: config.axios.defaults.baseURL,
        title: structure.edit.title,
        form: structure.edit.form,
        rules: structure.edit.rules
    }
}

// 配置

// 生成excel配置文件
let configExcel = {}
configExcel.fileName = structure.excel.fileName
configExcel.tHeader = [];
configExcel.filterVal = [];
structure.excel.fields.map(function(i) {
    configExcel.tHeader[configExcel.tHeader.length] = structure.fields[i].desc
    configExcel.filterVal[configExcel.filterVal.length] = i
})

// 生成table show状态字段配置文件
let tableShow = {}
tableShow.prop = [];
tableShow.items = [];
tableShow.width = structure.table.show.width;
structure.table.show.fields.map(function(i) {
    tableShow.prop[tableShow.prop.length] = i
    tableShow.items[tableShow.items.length] = structure.fields[i].desc
})

// 生成table hidden状态字段配置文件
let tableHidden = {}
tableHidden.prop = [];
tableHidden.items = [];
structure.table.hidden.fields.map(function(i) {
    tableHidden.prop[tableHidden.prop.length] = i
    tableHidden.items[tableHidden.items.length] = structure.fields[i].desc
})


// 配置可以排序的字段
// { CreateDate: 'custom' }
let tableSort = {}
structure.table.sort.fields.map(function(i) {
    tableSort[i] = 'custom';
})

// 搜索配置
// input
let search_input = []
structure.search.input.fields.map(function(i) {
    let res = {}
    res.name = i
    res.placeholder = structure.fields[i].desc
    search_input[search_input.length] = res
})

// select
let search_select = []
structure.search.select.fields.map(function(i) {
    let res = {}
    res.name = i
    res.placeholder = structure.fields[i].desc
    search_select[search_select.length] = res
})

configs.config = {
    skubaseApi: structure.skubaseApi,
    baseApi: structure.baseApi,
    excel: configExcel,
    table: {
        btnGroup: structure.table.batch.buttons,
        noGroup: !structure.table.batch.buttons.length,
        checkbox: true,
        sort: tableSort,
        show: tableShow,
        hidden: tableHidden,
        operate: structure.table.operator,
        tag:structure.table.tag,
        taglabel:'规格值'
    },
    search: {
        search_input: search_input,
        search_select: search_select
    },
    page: {
        limits: [5, 10, 20, 50, 100],
        layout: 'total, sizes, prev, pager, next, jumper'
    }
}

// Data
configs.data = {
    received: {
        table: [],
        count: null,
        search: structure.defaultSelectData
    },
    exchanged: {
        search: {  orderByString: '' },
        multipleSelection: [],
        isDelete: 0
    }
}

// Data
configs.selectInit = function() {
    let that = this
    structure.selectWait.map(function(index) {
        that.apiGet(index.url).then(res => {
            that.handelResponse(res, data => {
                data.list.map(function(i) {
                    i.value = i[index.option.value]
                    i.label = i[index.option.label]
                })
                that.Add.data.selectData[index.commitField] = data.list
                that.Edit.data.selectData[index.commitField] = data.list
                that.data.received.search[index.commitField] = data.list
            })
        })
    })
}

// 字段过滤
configs.filterData = structure.filterData

export default configs