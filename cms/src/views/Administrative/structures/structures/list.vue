<template>
	<List :data="data" :config="config"></List>
</template>

<script>
import List from 'components/tpl/list.vue'
import http from 'assets/js/http.js'

export default {
  components: {
    List
  },
  data() {
    return {
      config: {
        baseApi: 'admin/structures',
        crumb: [
          {
            to: '',
            name: '系统'
          },
          {
            to: '',
            name: '组织构架'
          },
          {
            to: '',
            name: '部门管理'
          }
        ],
        jump: [
          {
            to: 'add',
            name: '添加',
            class: 'btn-link-large add-btn',
            icon: 'el-icon-plus'
          }
        ],
        excel: {
          fileName: '表格',
          tHeader: ['序号', '单位名称', '组织机构代码', '单位类型', '级别', '坐落位置', '状态'],
          filterVal: [
            'id',
            'name',
            'orgcode',
            'type',
            'level',
            'position',
            'status'
          ]
        },
        table: {
          checkbox: true,
          status: true,
          show: {
            items: ['单位名称', '组织机构代码', '级别', '坐落位置'],
            prop: ['name', 'orgcode', 'level', 'position'],
            width: [200, 200, 200, 200, 200, 200, 200]
          },
          hidden: {
            items: ['单位类型'],
            prop: ['type']
          },
          operate: {
            link: [
              {
                name: 'structuresEdit',
                title: '编辑',
                class: 'el-icon-edit'
              }
            ],
            del: true
          }
        },
        search: {
          search_input: [
            {
              name: 'name',
              placeholder: '单位名称'
            },
            {
              name: 'orgcode',
              placeholder: '组织机构代码'
            }
          ],
          search_select: [
            {
              name: 'status',
              placeholder: '请选择状态',
              multiple: false
            },
            {
              name: 'level',
              placeholder: '请选择级别',
              multiple: false,
              filterable: true
            },
            {
              name: 'position',
              placeholder: '请选择坐落位置',
              multiple: false,
              filterable: true
            },
            {
              name: 'type',
              placeholder: '请选择类型',
              multiple: true,
              filterable: true
            }
          ]
        },
        page: {
          limits: [5, 10, 20, 50, 100],
          layout: 'total, sizes, prev, pager, next, jumper'
        }
      },
      data: {
        received: {
          table: [],
          count: null,
          search: {
            type: '',
            level: '',
            position: '',
            status: [
              {
                label: '启用',
                value: '1'
              },
              {
                label: '禁用',
                value: '0'
              }
            ]
          }
        },
        exchanged: {
          search: {
            limit: 10,
            page: 1,
            create_time: ''
          },
          date: {
            create_time: ''
          },
          multipleSelection: []
        }
      }
    }
  },
  created() {
    this.init()
    // 延迟绑定监听
    this.$watch('data.exchanged.search', {
      deep: true,
      handler: function() {
        router.push({ path: this.$route.path, query: this.getCondition() })
        _g.openGlobalLoading()
        console.log('this is data: ')
        console.log(this.data)
        this.tableData()
      }
    })
  },
  methods: {
    init() {
      // 基本数据获取
      this.tableData()

      // 自定义数据获取
      this.getLevel()
      this.getPosition()
      this.getType()
    },
    getType() {
      let url = 'admin/structureType'
      this.apiGet(url).then(res => {
        this.handelResponse(res, data => {
          this.data.received.search.type = data.list
          this.data.received.search.type.map(function(value) {
            value.label = value.type
            delete value.type
            value.value = value.id
            delete value.id
          })
        })
      })
    },
    getLevel() {
      let url = 'admin/structureLevel'
      this.apiGet(url).then(res => {
        this.handelResponse(res, data => {
          this.data.received.search.level = data.list
          this.data.received.search.level.map(function(value) {
            // 数据处理
            value.label = value.level
            delete value.level
            value.value = value.id
            delete value.id
            delete value.content
          })
        })
      })
    },
    getPosition() {
      let url = 'admin/structurePosition'
      this.apiGet(url).then(res => {
        this.handelResponse(res, data => {
          this.data.received.search.position = data.list
          this.data.received.search.position.map(function(value) {
            value.label = value.position
            delete value.position
            value.value = value.id
            delete value.id
          })
        })
      })
    },
    tableData() {
      // 表格数据
      const data = {
        params: this.getCondition()
      }
      // 请求地址
      let url = this.config.baseApi
      this.apiGet(url, data).then(res => {
        this.handelResponse(res, data => {
          this.data.received.table = data.list
          this.data.received.count = data.dataCount
          _g.closeGlobalLoading()
        })
      })
    },
    getCondition() {
      // 搜索优化配置
      let temp = this.data.exchanged.search
      let params = {}
      for (let key in temp) {
        if (temp[key]) {
          params[key] = temp[key]
        }
      }
      return params
    }
  },
  mixins: [http]
}
</script>

<style scoped>
.el-input,
.el-input__inner {
  width: auto;
}
</style>
