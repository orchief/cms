<template>
<div>
		<!-- 头部 -->
		<div class="m-b-20 ovf-hd">
			<!-- 页面跳转 -->
			<div class="fl">
        <!-- <el-button type="primary" icon="document" @click="add()" >新增</el-button> -->
			</div>
		</div>
		<!-- 头部 -->

		<!-- 表格 -->
    <el-table
            :data="data.received.table"
            stripe="stripe"
            :border='true'
            v-loading="loading_min"
            element-loading-text="拼命加载中"
            style="width: 100%"
            @sort-change="sortChange"
    >
        <!-- checkbox -->
        <!-- <el-table-column type="selection"	 width="50"></el-table-column> -->

        <el-table-column label="事件名称" prop="title"	 width="140"></el-table-column>
        <el-table-column label="消息内容" prop="content" width="200"></el-table-column>
        <el-table-column label="发送类型" prop="title"	 width="200">
          <template slot-scope="scope">
            <el-checkbox-group v-model="scope.row.msgtype">
              <el-checkbox readonly v-for="message in scope.row.messageType" :label="message.id">{{message.remark}}</el-checkbox>
            </el-checkbox-group>
          </template>
        </el-table-column>
        <el-table-column label="事件详情" prop="remark"	 width="300"></el-table-column>

        <!-- 操作 -->
        <el-table-column label="操作" >
            <template scope="scope">
                  <span  class="icon_button" >
                      <a href="javascript:;" @click="edit(scope.row)" title="编辑">
                          <i  class="el-icon-edit"></i>
                      </a>
                  </span>
                  <!-- <span  class="icon_button" >
                      <a href="javascript:;" @click="confirmDelete(scope.row)" title="删除">
                          <i  class="el-icon-delete"></i>
                      </a>
                  </span> -->
            </template>
        </el-table-column>
    </el-table>
		<!-- 表格 -->

    <!-- 新增 -->
    <el-dialog title="新增轮播" :visible.sync="Add.dialogFormVisible" @close='Add.dialogFormVisible = false'>
      <el-form ref="form" :model="Add.data.form" label-width="130px">
				
        <el-form-item label="跳转地址" prop="uri">
          <el-input v-model.trim="Add.data.form.uri" class="h-40 w-200" :maxlength="255" ></el-input>
        </el-form-item>

        <el-form-item label="轮播图" prop="path">
         <el-upload
            class="avatar-uploader"
            :action="Add.config.uploadUrl"
            :show-file-list="false"
            :on-success="handleAvatarSuccess"
            :before-upload="beforeAvatarUpload">
            <img v-if="Add.data.form.path" :src="config.ResourceBaseUrl + Add.data.form.path" class="avatar">
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

    <!-- 编辑 -->
    <el-dialog title="编辑" :visible.sync="Edit.dialogFormVisible">
      <el-form ref="form" :model="Edit.data.form" label-width="160px">
				
        <el-form-item label="事件标题" prop="title">
          <el-input v-model.trim="Edit.data.form.title" class="h-40 w-200" :maxlength="255" ></el-input>
        </el-form-item>

        <el-form-item label="事件备注" prop="remark">
          <el-input v-model.trim="Edit.data.form.remark" class="h-40 w-200" :maxlength="255" ></el-input>
        </el-form-item>
        <el-form-item label="发送类型" prop="types">
          <el-checkbox-group v-model="Edit.data.form.msgtype">
              <el-checkbox readonly v-for="message in Edit.data.form.messageType" :label="message.id">{{message.remark}}</el-checkbox>
            </el-checkbox-group>
        </el-form-item>
	</el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="Edit.dialogFormVisible = false">取 消</el-button>
        <el-button type="primary" @click="commitEdit(row)">确 定</el-button>
      </div>
    </el-dialog>
    <!-- 编辑 -->

</div>

</template>

<script>
import http from 'assets/js/http.js'

export default {
  components: {
  },
  data() {
    return {
      config: {
        ResourceBaseUrl: window.ResourceBaseUrl,
        domain: window.axios.defaults.baseURL,
        baseApi: 'admin/MessageTemplate'
      },
      data: {
        received: {
          table: null
        }
      },
      Add: {
        config: {
          uploadUrl: window.axios.defaults.baseURL +  'admin/upload'
        },
        dialogFormVisible: false,
        data: {
          form: {
            uri: null,
            path: null
          }
        }
      },
      Edit: {
        config: {
          uploadUrl: window.axios.defaults.baseURL +  'admin/upload'
        },
        dialogFormVisible: false,
        data: {
          form: {
            title: null,
            remark: null
          }
        }
      }
    }
  },
  created() {
    this.init()
  },
  methods: {
    init() {
      // 基本数据获取
      this.getTableData()
    },
    messageType(){
      return this.apiGet('/admin/MessageType').then(res => {
        if(res.code==200){
          return res.data.list
        }
      })
    },
   async getTableData() {
      // 请求地址
      let that = this
      let url = this.config.baseApi;
      let messageType = await this.messageType();
      console.log(messageType)
      this.apiGet(url).then(res => {
        this.handelResponse(res, data => {
          this.data.received.table = data.list.map(item=>{
            return Object.assign(item,{
              messageType,
              msgtype:item.types.map(t=>{
                return t.id
              })
            })
          })
          this.data.received.count = data.dataCount
        })
      })
    },
    commitAdd() {
      this.$refs.form.validate(pass => {
        if (pass) {
          // 提交数据
          this.apiPost(this.config.baseApi, this.Add.data.form).then(res => {
            this.handelResponse(
              res,
              data => {
                this.getTableData();
                _g.toastMsg('success', res.data.msg)
                console.log('this', this);
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
    add(){
      this.Add.dialogFormVisible = true
    },
    edit(row) {
      this.Edit.data.primary = row.id;
      this.Edit.data.form = row;
      this.Edit.dialogFormVisible = true;
    },
    commitEdit(){
      console.log(row)
      let row = this.Edit.data.form;
      row.types = []
      row.msgtype.map(selemsg=>{
        row.messageType.map(allmsg=>{
          if(selemsg==allmsg.id){
            row.types.push(Object.assign(allmsg,{
              pivod:{
                id:allmsg.id,
                tempId:row.id,
                typeId:allmsg.id
              }
            }))
          }
        })
      })
      this.$refs.form.validate(pass => {
        if (pass) {
          this.apiPut(
            this.config.baseApi + "/",
            this.Edit.data.primary,
            this.Edit.data.form
          ).then(res => {
            this.handelResponse(res, data => {
              _g.toastMsg("success", "编辑成功");
              this.Edit.dialogFormVisible = false;
            });
          });
        }
      });
    },
    sortChange(column) {
      if (column.prop === null || column.order === null) {
        this.exchanged.search.orderByString = "";
      } else {
        this.exchanged.search.orderByString = column.prop + "." + column.order;
      }
    },
    selectItem(val) {
      // checkbox方法
      this.exchanged.multipleSelection = val;
    },
    confirmDelete(item) {
      this.$confirm("确认删除?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          _g.openGlobalLoading()
          this.apiDelete(this.config.baseApi + "/", item.id).then(res => {
            this.handelResponse(res, data => {
              this.getTableData();
              _g.toastMsg("success", "删除成功");
            });
          });
        })
        .catch(() => {
          // catch error
        });
    },
    handleAvatarSuccess(res, file) {
      console.log('res', res)
      this.Add.data.form.path = res.data;
      this.Edit.data.form.path = res.data;
    },
    beforeAvatarUpload(file) {
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
.el-checkbox{
  display:block;
  margin-left: 0;
}
</style>
