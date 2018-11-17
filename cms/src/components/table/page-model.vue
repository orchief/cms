<template>
    <div class="block pages" >
        <el-pagination
                @size-change="handlePageLimit"
                @current-change="handlePageChange"
                :current-page="currentPage"
                :page-sizes="config.limits"
                :page-size="limit"
                :layout="config.layout"
                :total="dataCount">
        </el-pagination>
    </div>
</template>

<script>
export default {
  props: ['data', 'config', 'dataCount', 'limit', 'currentPage'],
  data() {
    return {}
  },
  methods: {
    handlePageLimit(size) {
      this.data.exchanged.search.limit = size
      // 修改limit的时候定位到第一页
      this.data.exchanged.search.page = 1
    },
    handlePageChange(currentPage) {
      this.data.exchanged.search.page = currentPage
    }
  },
  created() {}
}
</script>

<style scoped>
.el-select > .el-input {
  width: 50px !important;
}
.el-input,
.el-input__inner {
  width: 50px !important;
}
</style>