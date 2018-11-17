<template>
  <restTable></restTable>
</template>

<script>

import restTable from './table.vue'

export default {
  components: {
    restTable
  },
    created() {
    // 延迟绑定监听
    // this.$watch('data.exchanged.search', {
    //   deep: true,
    //   handler: function() {
    //     router.push({ path: this.$route.path, query: this.getCondition() })
    //     _g.openGlobalLoading()
    //     this.tableData()
    //   }
    // })
    // this.$watch('data.exchanged.isDelete', {
    //   deep: true,
    //   handler: function() {
    //     _g.openGlobalLoading()
    //     this.tableData()
    //   }
    // })
  },
}
</script>