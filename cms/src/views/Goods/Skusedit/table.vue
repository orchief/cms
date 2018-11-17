<template>
<div>
		
		<!-- 内容 -->
    <el-tabs type="card" :before-leave="fss" :value="tabsValue" @tab-click="tabClickHandle">
      <el-tab-pane name="sku" label="类型" >
          <el-form ref="form" :model="Add.data.formsku" :rules="Add.config.rules" label-width="130px">
				
        <!-- 普通输入类型 -->
        <el-form-item :label="item.label" :prop="item.prop" v-for="item in Add.config.formsku.input">
          <el-input v-model.trim="Add.data.formsku[item.prop]" class="h-40 w-200" :maxlength="255" ></el-input>
        </el-form-item>
			</el-form>
      <el-button type="primary" @click="commitNext">修改</el-button>
      </el-tab-pane>
      <el-tab-pane name="attr" label="规格">
        	<div class="fl" style="margin-bottom:20px;">
        <el-button type="primary" icon="document" @click="AddItems" v-if="Add.show">新增规格</el-button>
        	</div> 
          <table-model ref='table' v-loading="showLoading" :Edit="Edit" :tableData="data.received.table" :config="config.table" :exchanged="data.exchanged" :baseApi="config.baseApi"></table-model>
      <div class="pos-rel p-t-20">
         <el-button :size="'small'"  @click="bindSkuAttr()">绑定规格</el-button>
        <el-button :size="'small'"  @click="unbindSkuAttr()">解除绑定</el-button>
      </div>
      </el-tab-pane>
      </el-tabs>
     
		
		<!-- 内容 -->
  
	
        <!-- 新增 -->
       <el-dialog :title="Add.config.title" :visible.sync="Add.dialogFormVisible">
      <el-form ref="form" :model="Add.data.form" :rules="Add.config.rules" label-width="130px">
				
        <!-- 普通输入类型 -->
        <el-form-item :label="item.label" :prop="item.prop" v-for="item in Add.config.form.input">
          <el-input v-model.trim="Add.data.form[item.prop]" class="h-40 w-200" :maxlength="255" ></el-input>
        </el-form-item>

        <el-form-item :label="item.label" :prop="item.prop" v-for="item in Add.config.form.select" >
          <el-select multiple filterable allow-create  default-first-option v-model="Add.data.form[item.prop]" 
          :placeholder="item.placeholder" class="w-200">
            <el-option v-for="option in Add.data.selectData[item.prop]" :label="option.label" :value="option.value"></el-option>
          </el-select>
        </el-form-item>
      
        <el-form-item :label="item.label" :prop="item.prop" v-for="item in Add.config.form.multipleSelect">
          <el-select filterable v-model="Add.data.form[item.prop]" :placeholder="item.placeholder" class="w-200" multiple>
            <el-option v-for="option in Add.data.selectData[item.prop]" :label="option.label" :value="option.value"></el-option>
          </el-select>
        </el-form-item>

        <!-- 图片上传 -->
        <el-form-item :label="this.Add.config.form.uploadImg.label" v-if="this.Add.config.form.uploadImg.label">
          <el-upload
          class="avatar-uploader"
          :action = "Add.config.uploadUrl"
          :show-file-list="false"
          :on-success="handleAvatarSuccess"
          :before-upload="beforeAvatarUpload">
          <img v-if="Add.data.form[this.Add.config.form.uploadImg.prop]" :src="Add.config.domain + Add.data.form[this.Add.config.form.uploadImg.prop]" class="avatar">
          <i v-else class="el-icon-plus avatar-uploader-icon"></i>
          </el-upload>
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
    return Object.assign(base,{sku:0,skulist:[],tabsValue:'sku',attributeValues:[],
    optionsattr: [],})
  },
  created() {
    this.data.exchanged.search.userId = this.$route.query.id
    
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
    tabClickHandle(v){
      this.tabsValue=v.name
    },
    fss(activeName, oldActiveName){
      return true;
      if(activeName==this.tabsValue){
        return true
      }else{
        return false;
      }
      
    },
    bindSkuAttr(){
      let paramsData=[];
          this.data.exchanged.multipleSelection.map((attr)=>{
            paramsData.push({
              groupId:this.$route.query.id,
              attributeId:attr.id
            })
          })
          this.apiPost('/admin/GoodsAttributeToGroup/saves', paramsData).then(res => {
            this.handelResponse(
              res,
              data => {
                _g.toastMsg('success', '绑定成功');
                this.$router.go(-1)
                this.tableData()
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
              groupId:this.$route.query.id,
              attributeId:attr.id
            })
          })
        this.apiPost('/admin/GoodsAttributeToGroup/deletes', paramsData).then(res => {
          this.handelResponse(
            res,
            data => {
              _g.toastMsg('success', '解除成功');
              this.$router.go(-1)
              this.tableData()
            },
            () => {
              this.isLoading = !this.isLoading
            }
          )
        })
    },
    AddItems() {
      this.Add.dialogFormVisible = true // 显示窗体
    },
    
    async tableData() {
      // 表格数据
      const data = {
        params: this.getCondition()
      }
      // 请求地址
      let that = this
      
      let url = this.config.skubaseApi
       let getSelData =  await  this.apiGet(url+'/'+this.$route.query.id, data).then(res => {
         this.handelResponse(res, data => {
          this.Add.data.formsku.name = data.name;
          this.Add.data.formsku.desc =data.desc;
        })
        if(res.code==200){
          return res.data.attributes;
        }else{
          return [];
        }
      })
      
      this.apiGet(this.config.baseApi, data).then(res => {
        this.handelResponse(res, data => {
          
          data.list.map(function(i) {
            that.config.table.tag[i.id] = i.attributeValues.map((attr)=>{
              return attr.valueStr
            })
          })
          this.data.received.table = data.list;
          getSelData.map((s,i)=>{
            data.list.map(function(d) {
              if(s.id==d.id){
                that.$nextTick(()=>{
                  that.$refs.table.$refs.table.toggleRowSelection(d,true); 
                })
              }
            })
          })
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
    commitNext(){
      if(this.tabsValue=='sku'){
        this.commitSkuEdit()
      }
    },
    commitSkuEdit() {
      this.$refs.form.validate(pass => {
        if (pass) {
          this.apiPut(
            this.config.skubaseApi + "/",
            this.$route.query.id,
            this.Add.data.formsku
          ).then(res => {
            this.handelResponse(res, data => {

              _g.toastMsg('success', '修改成功');
            });
          });
        }
      });
    },
    commitAdd() {
      
      this.$refs.form.validate(pass => {
        if (pass) {
          let attributeValues = this.Add.data.form.attributeValues.map(att=>{
            return {
              valueStr:att
            }
          })
          // 提交数据
          this.apiPost(this.config.baseApi, {
            attributeName:this.Add.data.form.attributeName,
            attributeValues:attributeValues
          }).then(res => {
            this.handelResponse(
              res,
              data => {
                _g.toastMsg('success', res.data.msg)
                this.tableData()
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
