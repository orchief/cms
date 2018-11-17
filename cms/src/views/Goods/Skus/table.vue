<template>
<div>
			<!-- 头部 -->
		<div class="m-b-20 ovf-hd">
			<!-- 页面跳转 -->
			<div class="fl">
        <el-button type="primary" icon="document"  v-if="Add.show"><router-link style="color: #fff;" :to="'/cms/goods/skusadd'" >新增</router-link></el-button>
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
			<table-model v-loading="showLoading" :Edit="Edit" :tableData="data.received.table" :config="config.table" :exchanged="data.exchanged" :baseApi="config.baseApi"></table-model>
    </transition>
    
</el-tabs>
		
		<!-- 内容 -->

		<!-- 底部 -->
		<div class="pos-rel p-t-20">
			<!-- 批量操作 -->
			<btnGroup  v-if="!config.table.noGroup"  :selectedData="data.exchanged.multipleSelection" :baseApi="config.baseApi" :config="config.table.btnGroup" :exchanged="data.exchange"></btnGroup>
			<!-- 翻页操作 -->
			<page-model :data="data" :config="config.page" :dataCount="data.received.count" :limit="data.exchanged.search.limit" :currentPage="data.exchanged.search.page"></page-model>
		</div>
		 <!--底部 -->
        <!-- 新增 -->
    
</div>

</template>

<script>
import http from 'assets/js/http.js'
import btnGroup from 'components/table/btn-group.vue'
import downExcel from 'components/table/down-excel.vue'
import tableModel from 'components/table/table-model.vue'
import searchModel from 'components/table/search-model.vue'
import pageModel from 'components/table/page-model.vue'
import base from './base.js'
export default {
  components: {
    btnGroup,
    downExcel,
    tableModel,
    searchModel,
    pageModel
  },
  data() {
    return Object.assign(base,{sku:0,skulist:[]})
  },
  created() {
    this.data.exchanged.search.userId = this.$route.params.id
    this.init()
    // 延迟绑定监听
    this.$watch('data.exchanged.search', {
      deep: true,
      handler: function() {
        router.push({ path: this.$route.path, query: this.getCondition() })
        _g.openGlobalLoading()
        this.tableData()
      }
    })
    this.$watch('data.exchanged.isDelete', {
      deep: true,
      handler: function() {
        _g.openGlobalLoading()
        this.tableData()
      }
    })
  },
  methods: {
    init() {
      // 基本数据获取
      this.tableData()
      this.selectInit()
      
    },
    AddItems() {
      this.Add.dialogFormVisible = true // 显示窗体
    },
    tableData() {
      // 表格数据
      const data = {
        params: this.getCondition()
      }
      // 请求地址
      let that = this
      let url = this.config.baseApi
      this.apiGet(url, data).then(res => {
        this.handelResponse(res, data => {
          
          data.list.map(function(i) {
            that.filterData.map(function (index) {
              index.exchange.map(function (ii) {
                if (i[index.originField] == ii.origin) {
                    i[index.showField] = ii.show
                  }
              })
            })
            that.config.table.tag[i.id] = i.attributes.map((attr)=>{
              return attr.attributeName
            })
          })
          this.data.received.table = data.list;
          this.data.received.count = data.dataCount;
          _g.closeGlobalLoading()
        })
      })
      
      this.apiGet('admin/GoodsAttribute', data).then(res => {
        this.handelResponse(res, data => {
          
          console.log(data)
          this.skulist = data.list
          _g.closeGlobalLoading()
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
    },
    commitAdd() {
      this.$refs.form.validate(pass => {
        if (pass) {
          // 提交数据
          this.apiPost(this.config.baseApi, this.Add.data.form).then(res => {
            this.handelResponse(
              res,
              data => {
                _g.toastMsg('success', res.data)
                this.data.exchanged.isDelete++
                this.Add.dialogFormVisible = false // 显示窗体
              },
              () => {
                this.isLoading = !this.isLoading
              }
            )
          })
        }
      })
    },
    handleAvatarSuccess(res, file) {
      this.Add.data.form[this.Add.config.form.uploadImg.prop] = res.data
    },
    beforeAvatarUpload(file) {
      const isLt2M = file.size / 1024 / 1024 < 2
      if (!isLt2M) {
        this.$message.error('上传图片大小不能超过 2MB!')
      }
      return isLt2M
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
