<template>
    <div class="fl" style="margin-left: 15px">
        <el-button style='margin-bottom:20px;' type="primary" icon="document" @click="nowPageData" :loading="downloadLoading_now" v-if="tableData">导出当页excel</el-button>
        <el-button style='margin-bottom:20px;' type="primary" icon="document" @click="allPageData" :loading="downloadLoading_all" v-if="tableData">导出全部excel</el-button>
    </div>
</template>

<script>
import http from '../../assets/js/http'
export default {
  props: ['baseApi', 'config', 'conditions', 'tableData'],
  data() {
    return {
      downloadLoading_now: false,
      downloadLoading_all: false,
      loading: false,
      allData: null
    }
  },
  methods: {
    handleDown(data_data) {
      // 当前页
      let that = this
      require.ensure([], () => {
        const { export_json_to_excel } = require('vendor/Export2Excel')
        // 导出表格配置信息
        const tHeader = this.config.tHeader
        const filterVal = this.config.filterVal
        const fileName = this.config.fileName
        const list = data_data
        const data = this.formatJson(filterVal, list)
        that.downloadLoading_all = false
        export_json_to_excel(tHeader, data, fileName)
      })
    },
    allPageData() {
      this.downloadLoading_all = true
      // 获取全部数据
      const data = {
        params: this.getCondition()
      }
      data.params.limit = -1
      // 请求地址
      let that = this
      let url = this.baseApi
      this.apiGet(url, data).then(res => {
        this.handelResponse(res, data => {
          that.handleDown(data.list)
        })
      })
    },
    nowPageData() {
      this.downloadLoading_now = true
      this.handleDown(this.tableData)
      this.downloadLoading_now = false
    },
    getCondition() {
      // 搜索优化配置
      let temp = this.conditions
      let params = {}
      for (let key in temp) {
        if (temp[key]) {
          params[key] = temp[key]
        }
      }
      return params
    },
    formatJson(filterVal, jsonData) {
      let that = this
      return jsonData.map(v =>
        filterVal.map(j => {
          switch (j) {
            case 'status':
              // 格式化状态
              if (parseInt(v[j]) === 1) {
                if (that.filterMsg) {
                  return that.filterMsg[0]
                } else {
                  return '启用'
                }
              } else {
                if (that.filterMsg) {
                  return that.filterMsg[1]
                } else {
                  return '禁用'
                }
              }
              break
            default:
              return v[j]
          }
        })
      )
    }
  },
  created() {},
  mixins: [http]
}
</script>

<style scoped>
.el-button {
  padding: 9px 20px !important;
}
</style>