<template>
	<div>
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
		<table-model :tableData="data.received.table" :config="config.table" :exchanged="data.exchanged" :baseApi="config.baseApi"></table-model>
		<!-- 内容 -->

		<!-- 底部 -->
		<div class="pos-rel p-t-20">
			<!-- 批量操作 -->
			<btnGroup  v-if="!config.table.noGroup"  :selectedData="data.exchanged.multipleSelection" :baseApi="config.baseApi" :config="config.btnGroup"></btnGroup>
			<!-- 翻页操作 -->
			<page-model :data="data" :config="config.page" :dataCount="data.received.count" :limit="data.exchanged.search.limit" :currentPage="data.exchanged.search.page"></page-model>
		</div>
		 <!--底部 -->
	</div>
</template>

<script>
import btnGroup from './components/btn-group.vue'
import downExcel from 'components/Common/down-excel.vue'
import tableModel from 'components/Common/table-model.vue'
import searchModel from 'components/Common/search-model.vue'
import pageModel from 'components/Common/page-model.vue'

export default {
  props: ['data', 'config'],
  components: {
    btnGroup,
    downExcel,
    tableModel,
    searchModel,
    pageModel
  },
  data() {
    return {}
  }
}
</script>
