<template>
	<el-dialog ref="dialog" custom-class="bg-wh tx-c box-shadow-none" :visible.sync="dialogVisible">
		<img :src="url">
	</el-dialog>
</template>
<style>
.box-shadow-none {
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0);
}
</style>
<script>
export default {
  props: ['url'],
  data() {
    return {
      dialogVisible: false
    }
  },
  methods: {
    open() {
      this.dialogVisible = true
      this.$refs.dialog.open()
    }
  }
}
</script>