// 为了实现功能的基础配置
import config from 'src/config.js'
import structure from '../config.js';
import { editorOptions } from './ueditorConfig.js'

const configs = {
    Add: null,
    Edit: null,
    Config: null,
    Data: null
}

configs.Options = editorOptions

let AdddataForm = {}
structure.add.form.map(function(i) {
    AdddataForm[i.prop] = null
})

// 新怎页面配置
configs.Add = {
    show: structure.add.show,
    dialogFormVisible: false,
    data: {
        primary: '',
        form: AdddataForm,
        selectData: structure.defaultSelectData
    },
    config: {
        uploadUrl: config.axios.defaults.baseURL + 'admin/upload',
        domain: config.ResourceBaseUrl,
        title: structure.add.title,
        form: structure.add.form,
        rules: structure.add.rules
    }
}


// 编辑页面配置
let EditdataForm = {}
structure.add.form.map(function(i) {
    EditdataForm[i.prop] = null
})

configs.Edit = {
    dialogFormVisible: false,
    data: {
        primary: '',
        form: structure.edit.form,
        selectData: structure.defaultSelectData
    },
    config: {
        uploadUrl: config.axios.defaults.baseURL + 'admin/upload',
        domain: config.ResourceBaseUrl,
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

// console.log('configExcel', configExcel)

// 配置可以排序的字段
// { CreateDate: 'custom' }
let tableSort = {}
structure.table.sort.fields.map(function(i) {
    tableSort[i] = 'custom';
})

configs.config = {
    baseApi: structure.baseApi,
    excel: configExcel,
    table: {
        btnGroup: structure.table.batch.buttons,
        noGroup: !structure.table.batch.buttons.length,
        checkbox: structure.table.batch.buttons.length,
        sort: tableSort,
        show: tableShow,
        hidden: tableHidden,
        operate: structure.table.operator
    },
    search: structure.search,
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
            search: { limit: 5, page: 1, orderByString: '' },
            multipleSelection: [],
            isDelete: 0
        }
    }
    // Data
configs.selectInit = function() {
    let that = this
    structure.defaultSelectDataApi.map(function(index) {
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
console.log(1);

// 字段过滤
configs.filterData = structure.filterData

export default configs