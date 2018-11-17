<template>
	<div>
		<!-- 头部 -->
		<div class="m-b-20 ovf-hd">
			<!-- 页面跳转 -->
			<div class="fl">
        <el-button type="primary" icon="document" @click="Add" >新增</el-button>
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
		<transition name="fade" mode="out-in" appear>
			<table-model v-loading="showLoading" :tableData="data.received.table" :config="config.table" :exchanged="data.exchanged" :baseApi="config.baseApi"></table-model>
    </transition>
		<!-- 内容 -->

		<!-- 底部 -->
		<div class="pos-rel p-t-20">
			<!-- 批量操作 -->
			<btnGroup  v-if="!config.table.noGroup"  :selectedData="data.exchanged.multipleSelection" :baseApi="config.baseApi" :config="config.btnGroup" :exchanged="data.exchange"></btnGroup>
			<!-- 翻页操作 -->
			<page-model :data="data" :config="config.page" :dataCount="data.received.count" :limit="data.exchanged.search.limit" :currentPage="data.exchanged.search.page"></page-model>
		</div>
		 <!--底部 -->

	</div>
</template>

<script>
import btnGroup from '../Common/btn-group.vue'
import downExcel from '../Common/down-excel.vue'
import tableModel from '../Common/table-model.vue'
import searchModel from '../Common/search-model.vue'
import pageModel from '../Common/page-model.vue'

export default {
  props: ['data', 'config', 'showLoading', 'Edit'],
  components: {
    btnGroup,
    downExcel,
    tableModel,
    searchModel,
    pageModel
  },
  data() {
    return {
      dialogFormVisible: false
    }
  },
  methods: {
    Add() {
      this.getData()
      this.dialogFormVisible = true // 显示窗体
    },
    getData() {
      // 获取备选项
    }
  }
}
</script>
