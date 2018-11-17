<template>
    <List :data="data" :config="config" :showLoading="showLoading"></List>
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
        baseApi: 'admin/syslogs',
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
          },
          {
            to: '',
            name: '操作日志'
          }
        ],
        excel: {
          fileName: '用户列表',
          tHeader: ['用户名', '时间', '请求详情', '请求数据'],
          filterVal: ['username', 'create_time', 'URI', 'data']
        },
        table: {
          noGroup: true,
          sort: {
            create_time: 'custom'
          },
          show: {
            items: ['用户名', '时间', '请求详情', '请求数据'],
            prop: ['username', 'create_time', 'URI', 'data'],
            width: [150, 200, 400, 200]
          },
          operate: {
            del: true
          }
        },
        search: {
          search_input: [
            {
              name: 'username',
              placeholder: '用户名'
            },
            {
              name: 'URI',
              placeholder: '请求详情'
            },
            {
              name: 'data',
              placeholder: '请求数据'
            }
          ],
          search_select: [],
          date: [
            {
              name: 'create_time',
              placeholder: '时间',
              type: 'datetimerange',
              separator: '--'
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
          search: {}
        },
        exchanged: {
          search: {
            uid: '',
            limit: 10,
            page: 1,
            create_time: '',
            orderByString: ''
          },
          date: {
            create_time: ''
          },
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
    this.$watch('$route', {
      deep: true,
      handler: function() {
        this.init()
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
      this.data.exchanged.search.uid = this.$route.params.id
      this.tableData()
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
