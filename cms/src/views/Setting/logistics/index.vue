<template>
  <restTable></restTable>
</template>

<script>

import restTable from './table.vue'

export default {
  components: {
    restTable
  },
  created(){
    _g.closeGlobalLoading()
  }
}
</script>