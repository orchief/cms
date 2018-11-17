<template>
<div>
			<!-- 头部 -->
		<div class="m-b-20 ovf-hd">
			<!-- 页面跳转 -->
			<div class="fl">
        <el-button type="primary" icon="document" @click="AddItems" v-if="Add.show">新增</el-button>
			</div>
			<!-- 导出Excel表格 -->
		</div>
		<!-- 头部 -->

		<!-- 内容 -->
		<transition name="fade" mode="out-in" appear>
			<table-model ref="table" v-loading="showLoading" :Edit="Edit" :tableData="data.received.table" :config="config.table" :exchanged="data.exchanged" :baseApi="config.baseApi"></table-model>
    </transition>
		<!-- 内容 -->

		<!-- 底部 -->
		<div class="pos-rel p-t-20">
			<!-- 批量操作 -->
      <el-button :size="'small'"  @click="bindSkuAttr()">绑定规格</el-button>
      <el-button :size="'small'"  @click="unbindSkuAttr()">解除绑定</el-button>
			<!-- 翻页操作 -->
			<page-model :data="data" :config="config.page" :dataCount="data.received.count" :limit="data.exchanged.search.limit" :currentPage="data.exchanged.search.page"></page-model>
		</div>
		 <!--底部 -->
        <!-- 新增 -->
    <el-dialog :title="Add.config.title" :visible.sync="Add.dialogFormVisible">
      <el-form ref="form" :model="Add.data.form" :rules="Add.config.rules" label-width="130px">
				
        <!-- 普通输入类型 -->
        <el-form-item :label="item.label" :prop="item.prop" v-for="item in Add.config.form.input">
          <el-input v-model.trim="Add.data.form[item.prop]" class="h-40 w-200" :maxlength="255" ></el-input>
        </el-form-item>

        <el-form-item :label="item.label" :prop="item.prop" v-for="item in Add.config.form.select">
          <el-select filterable v-model="Add.data.form[item.prop]" :placeholder="item.placeholder" class="w-200">
            <el-option v-for="option in Add.data.selectData[item.prop]" :label="option.label" :value="option.value"></el-option>
          </el-select>
        </el-form-item>

        <el-form-item :label="item.label" :prop="item.prop" v-for="item in Add.config.form.multipleSelect">
          <el-select filterable v-model="Add.data.form[item.prop]" :placeholder="item.placeholder" class="w-200" multiple>
            <el-option v-for="option in Add.data.selectData[item.prop]" :label="option.label" :value="option.value"></el-option>
          </el-select>
        </el-form-item>

        

			</el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="Add.dialogFormVisible = false">取 消</el-button>
        <el-button type="primary" @click="commitAdd">确 定</el-button>
      </div>
    </el-dialog>
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
    return base
  },
  created() {
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
  mounted() {
  },
  methods: {
    init() {
      // 基本数据获取
      this.tableData()
      this.selectInit()
      
    },
    AddItems() {
      for (let i in this.Add.data.form){
        this.Add.data.form[i] = ''
      }
      this.Add.dialogFormVisible = true // 显示窗体
    },
    bindSkuAttr(){
      let paramsData=[];
      this.data.exchanged.multipleSelection.map((attr)=>{
        paramsData.push({
          attributeId:this.$route.query.id,
          valueId:attr.id
        })
      })
      this.apiPost('/admin/GoodsAttributeToValues/saves', paramsData).then(res => {
        this.handelResponse(
          res,
          data => {
            _g.toastMsg('success', '绑定成功');
            this.$router.go(-1)
          },
          () => {
            this.isLoading = !this.isLoading
          }
        )
      })
    },
    unbindSkuAttr(){
      var that = this;
      let paramsData=[];
        this.data.exchanged.multipleSelection.map((attr)=>{
          paramsData.push({
            attributeId:this.$route.query.id,
            valueId:attr.id
          })
        })
        this.apiPost('/admin/GoodsAttributeToValues/deletes', paramsData).then(res => {
          this.handelResponse(
            res,
            data => {
              _g.toastMsg('success', '解除成功');
              this.$router.go(-1)
            },
            () => {
              this.isLoading = !this.isLoading
            }
          )
        })
    },
    async tableData() {
      // 表格数据
      const data = {
        params: this.getCondition()
      }
      // 请求地址
      let that = this
      let url = this.config.baseApi;
      let getSelData =  await this.apiGet('/admin/GoodsAttribute/'+this.$route.query.id, data).then(res => {
        if(res.code==200){
          return res.data.attributes;
        }else{
          return [];
        }
          
      })
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
          })
          this.data.received.table = data.list;
          this.data.received.count = data.dataCount
          
            getSelData.map((s,i)=>{
              data.list.map(function(d) {
                if(s.id==d.id){
                  that.$nextTick(()=>{
                    that.$refs.table.$refs.table.toggleRowSelection(d,true); 
                  })
                }
              })
            })
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
                _g.toastMsg('success', res.data.msg)
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
    handleAvatarSuccess1(res){
      this.Add.data.form[this.Add.config.form.uploadImg[0].prop] = res.data
    },
    handleAvatarSuccess2(img){
      this.Add.data.form[this.Add.config.form.uploadImg[1].prop] = res.data
    },
    handleAvatarSuccess3(img){
      this.Add.data.form[this.Add.config.form.uploadImg[2].prop] = res.data
    },
    beforeAvatarUpload1(file){
      const isLt2M = file.size / 1024 / 1024 < 2;
      if (!isLt2M) {
        this.$message.error("上传图片大小不能超过 2MB!");
      }
      return isLt2M;
    },
    beforeAvatarUpload2(file){
      const isLt2M = file.size / 1024 / 1024 < 2;
      if (!isLt2M) {
        this.$message.error("上传图片大小不能超过 2MB!");
      }
      return isLt2M;
    },
    beforeAvatarUpload3(file){
      const isLt2M = file.size / 1024 / 1024 < 2;
      if (!isLt2M) {
        this.$message.error("上传图片大小不能超过 2MB!");
      }
      return isLt2M;
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
