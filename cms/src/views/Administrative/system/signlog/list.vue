<template>
    <div>
        <div >
          <!-- 头部 -->
          <div class="m-b-20 ovf-hd">
              <!-- 页面跳转 -->
              <div class="fl">
                  <router-link :class="router.class" :to="router.to" v-for="router in config.jump">
                      <i :class="router.icon"></i>&nbsp;&nbsp;{{ router.name }}
                  </router-link>
              </div>
              <!-- 导出Excel表格 -->
              <downExcel :baseApi="config.baseApi" :config="config.excel" :tableData="data.received.table" :conditions="data.exchanged.search"></downExcel>
              <div>
                  <!-- 搜索 -->
                  <search-model :config="config.search" :data="data"></search-model>
              </div>
          </div>
          <!-- 头部 -->

          <!-- 内容 -->
          <table-model  :tableData="data.received.table" :config="config.table" :exchanged="data.exchanged" :baseApi="config.baseApi"></table-model>
          <!-- 内容 -->

          <!-- 底部 -->
          <div class="pos-rel p-t-20">
              <btnGroup :selectedData="data.exchanged.multipleSelection" :baseApi="config.baseApi" :config="config.btnGroup"></btnGroup>
              <!-- 翻页操作 -->
              <page-model :data="data" :config="config.page" :dataCount="data.received.count" :limit="data.exchanged.search.limit" :currentPage="data.exchanged.search.page"></page-model>
          </div>
          <!-- 底部 -->
          </div>
    </div>
</template>

<script>
import btnGroup from './components/btn-group.vue'
import http from 'assets/js/http'
import downExcel from 'components/Common/down-excel.vue'
import tableModel from 'components/Common/table-model.vue'
import searchModel from 'components/Common/search-model.vue'
import pageModel from 'components/Common/page-model.vue'

export default {
  components: {
    btnGroup,
    downExcel,
    tableModel,
    searchModel,
    pageModel
  },
  data() {
    return {
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
          form: null,
          search: {
            login_time: '',
            uid: [],
            ip: '',
            limit: 10,
            page: 1,
            orderByString: ''
          },
          date: {
            login_time: ''
          },
          multipleSelection: []
        }
      },
      config: {
        baseApi: 'admin/signlogs',
        crumb: [
          {
            to: '',
            name: '系统'
          },
          {
            to: '',
            name: '系统配置'
          },
          {
            to: '',
            name: '登陆日志'
          }
        ],
        excel: {
          fileName: '表格',
          tHeader: ['用户', '时间', 'ip'],
          filterVal: ['username', 'login_time', 'ip']
        },
        table: {
          checkbox: true,
          sort: {
            username: 'custom',
            login_time: 'custom',
            ip: 'custom'
          },
          show: {
            items: ['用户', '时间', 'ip'],
            prop: ['username', 'login_time', 'ip'],
            width: [200, 200]
          }
        },
        search: {
          orderBy: [
            {
              name: 'stuffname',
              order: 'descending'
            },
            {
              name: 'create_time',
              order: 'descending'
            }
          ],
          search_input: [
            {
              name: 'username',
              placeholder: '用户'
            },
            {
              name: 'ip',
              placeholder: 'ip'
            }
          ],
          date: [
            {
              name: 'login_time',
              placeholder: '时间',
              type: 'datetimerange',
              separator: '--'
            }
          ]
        },
        btnGroup: {
          size: 'small'
        },
        page: {
          limits: [5, 10, 20, 50, 100],
          layout: 'total, sizes, prev, pager, next, jumper'
        }
      },
      loading_min: false
    }
  },
  created() {
    this.init()
    this.$watch('data.exchanged.search', {
      deep: true,
      handler: function() {
        router.push({ path: this.$route.path, query: this.getCondition() })
        // _g.openGlobalLoading()
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
          // _g.closeGlobalLoading()
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
  computed: {
    addShow() {
      return _g.getHasRule('users-save')
    },
    editShow() {
      return _g.getHasRule('users-update')
    },
    deleteShow() {
      return _g.getHasRule('users-delete')
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