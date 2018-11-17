<template>
    <div class="app-container">
        <el-button style='margin-bottom:20px;' type="primary" icon="document" @click="handleDownload" :loading="downloadLoading">导出excel</el-button>
        <el-table :data="list" v-loading.body="listLoading" element-loading-text="拼命加载中" border fit highlight-current-row>
            <el-table-column align="center" label='ID' width="95">
                <template scope="scope">
                    {{scope.$index}}
                </template>
            </el-table-column>
            <el-table-column label="文章标题">
                <template scope="scope">
                    {{scope.row.title}}
                </template>
            </el-table-column>
            <el-table-column label="作者" width="95" align="center">
                <template scope="scope">
                    <el-tag>{{scope.row.author}}</el-tag>
                </template>
            </el-table-column>
            <el-table-column label="阅读数" width="115" align="center">
                <template scope="scope">
                    {{scope.row.pageviews}}
                </template>
            </el-table-column>
            <el-table-column align="center" prop="created_at" label="发布时间" width="220">
                <template scope="scope">
                    <i class="el-icon-time"></i>
                    <span>{{scope.row.timestamp | parseTime('{y}-{m}-{d} {h}:{i}')}}</span>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
export default {
  data() {
    return {
      list: null,
      listLoading: true,
      downloadLoading: false
    }
  },
  created() {
    this.fetchData()
  },
  methods: {
    fetchData() {
      this.listLoading = false
      this.list = [
        {
          id: 1,
          title: '标题',
          author: '作者',
          pageviews: '100',
          timestamp: '2017.10.15',
          auditor: '编辑',
          forecast: 22,
          importance: 2,
          display_time: '2017.10.15'
        },
        {
          id: 2,
          title: '标题',
          author: '作者',
          pageviews: '100',
          timestamp: '2017.10.15',
          auditor: '编辑',
          forecast: 22,
          importance: 2,
          display_time: '2017.10.15'
        }
      ]
      _g.closeGlobalLoading()
    },
    handleDownload() {
      this.downloadLoading = true
      require.ensure([], () => {
        const { export_json_to_excel } = require('vendor/Export2Excel')
        const tHeader = ['序号', '文章标题', '作者', '阅读数', '发布时间']
        const filterVal = ['id', 'title', 'author', 'pageviews', 'display_time']
        const list = this.list
        const data = this.formatJson(filterVal, list)
        export_json_to_excel(tHeader, data, '列表excel')
        this.downloadLoading = false
      })
    },
    formatJson(filterVal, jsonData) {
      return jsonData.map(v =>
        filterVal.map(j => {
          if (j === 'timestamp') {
            return parseTime(v[j])
          } else {
            return v[j]
          }
        })
      )
    }
  }
}
</script>
