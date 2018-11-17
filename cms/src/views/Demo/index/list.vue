<template>
        <div class="pos-rel p-t-20">
            这里是模板介绍
        </div>
</template>

<script>
export default {
  data() {
    return {
      tableData: [],
      multipleSelection: [],
      fileList: [],
      IsShow: false
    }
  },
  created() {
    _g.closeGlobalLoading()
  }
}
</script>