<template>
	<List :data="data" :config="config" :showLoading="showLoading"></List>
</template>

<script>
import List from './components/list.vue'
import http from 'assets/js/http.js'

export default {
  components: {
    List
  },
  data() {
    return {
      config: {
        baseApi: 'admin/users',
        crumb: [
          {
            to: '',
            name: '系统'
          },
          {
            to: '',
            name: '账户管理'
          },
          {
            to: '',
            name: '账户列表'
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
          fileName: '用户列表',
          tHeader: ['用户名', '注册日期', '备注', '状态'],
          filterVal: ['username', 'create_time', 'remark', 'status']
        },
        table: {
          checkbox: true,
          status: true,
          sort: {
            username: 'custom',
            create_time: 'custom'
          },
          show: {
            items: ['用户名', '注册日期', '备注'],
            prop: ['username', 'create_time', 'remark'],
            width: [150, 200, 200, 250]
          },
          operate: {
            link: [
              {
                name: '编辑账户',
                title: '编辑',
                class: 'el-icon-edit'
              }
            ]
          }
        },
        search: {
          search_input: [
            {
              name: 'username',
              placeholder: '用户名'
            },
            {
              name: 'remark',
              placeholder: '备注'
            }
          ],
          search_select: [
            {
              name: 'status',
              placeholder: '请选择状态',
              multiple: false
            }
          ],
          date: [
            {
              name: 'create_time',
              placeholder: '日期',
              type: 'datetimerange',
              separator: '--',
              size: 'large'
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
            ability: '',
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
            create_time: '',
            orderByString: ''
          },
          date: {
            create_time: ''
          },
          multipleSelection: [],
          isDelete: 0
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
        this.tableData()
      }
    })
    this.$watch('data.exchanged.isDelete', {
      deep: true,
      handler: function() {
        _g.openGlobalLoading()
        this.tableData()
      }
    })
  },
  methods: {
    init() {
      // 基本数据获取
      this.tableData()
    },
    Ability() {
      let url = 'admin/items'
      this.apiGet(url).then(res => {
        this.handelResponse(res, data => {
          this.data.received.search.ability = data.list
          this.data.received.search.ability.map(function(value) {
            value.label = value.title
            delete value.title
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
      data.params.hasTotal = 1;
      // 请求地址
      let url = this.config.baseApi
      this.apiGet(url, data).then(res => {
        this.handelResponse(res, res => {
          this.data.received.table = res.list
          this.data.received.count = res.dataCount
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
