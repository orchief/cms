<template>
<div>
		<!-- 头部 -->
		<div class="m-b-20 ovf-hd">
			<!-- 页面跳转 -->
			<div class="fl">
        <el-button type="primary" icon="document" @click="add()" >新增分销商</el-button>
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

        <el-table-column label="分销商名称" prop="title"	 width="200"></el-table-column>
        <el-table-column label="分销商简介" prop="desc"	 width="300">
        </el-table-column>

        <el-table-column label="分销商图标" prop="logo"	 width="300">
          <template slot-scope="scope">
            <img :src="config.ResourceBaseUrl+scope.row.logo" alt="分销商logo" style="height:200px;width:200px">
          </template>
        </el-table-column>

        <!-- 操作 -->
        <el-table-column label="操作" >
            <template scope="scope">
                  <span  class="icon_button" >
                      <a href="javascript:;" @click="edit(scope.row)" title="编辑">
                          <i  class="el-icon-edit"></i>
                      </a>
                  </span>
                  <span  class="icon_button" >
                      <a href="javascript:;" @click="confirmDelete(scope.row)" title="删除">
                          <i  class="el-icon-delete"></i>
                      </a>
                  </span>
            </template>
        </el-table-column>
    </el-table>
		<!-- 表格 -->

    <!-- 新增 -->
    <el-dialog title="新增分销商" :visible.sync="Add.dialogFormVisible" @close='Add.dialogFormVisible = false'>
      <el-form ref="form" :model="Add.data.form" label-width="130px" :rules="Add.data.rules">
				
        <el-form-item label="分销商名称" prop="title">
          <el-input v-model.trim="Add.data.form.title" class="h-40 w-200" :maxlength="255" ></el-input>
        </el-form-item>

        <el-form-item label="分销商简介" prop="desc">
          <quill-editor 
              v-model="Add.data.form.desc"
              ref="myQuillEditor"
              :options="Options">
              </quill-editor>
        </el-form-item>

        <el-form-item label="分销商图标" prop="logo">
         <el-upload
            class="avatar-uploader"
            :action="Add.config.uploadUrl"
            :show-file-list="false"
            :on-success="handleAvatarSuccess"
            :before-upload="beforeAvatarUpload">
            <img v-if="Add.data.form.logo" :src="config.ResourceBaseUrl + Add.data.form.logo" class="avatar">
            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
          </el-upload>
        </el-form-item>

        <el-form-item label="成为分销商条件" prop="condition">
         <div style="border:1px solid #ddd;padding: 0 20px 20px 20px" v-for="conditon in Add.data.form.formula.condition">
              <div class="title">
                <span>{{conditon.title}}</span>
                <el-switch style="float:right;margin-top:12px;"
                  v-model="conditon.selected"
                  active-text="启用"
                  inactive-text="禁用">
                </el-switch>
              </div>
              <div style="border:1px solid #ddd;margin-top:10px;" v-for="item in conditon.items">
                
                <el-form-item v-if="item.type==1" :label="item.title" prop="condition">
                  <el-input :disabled="!conditon.selected" placeholder="" v-model="item.value" >
                  </el-input>
                </el-form-item>
                <el-form-item v-if="item.type==2"  :label="'请选择分成比例'" prop="condition">
                  <el-select :disabled="!conditon.selected" v-model="item.value"  >
                    <el-option :label="'普通'" :value="1"></el-option>
                    <el-option  :label="'高级'" :value="2"></el-option>
                </el-select>
                </el-form-item>
                <el-form-item v-for="extra in item.extra"  :label="extra.title" :prop="extra.field">
                  <el-input :disabled="!conditon.selected" v-model="extra.value" >
                  </el-input>
                </el-form-item>
              </div>
              
          </div>
        </el-form-item>

        <el-form-item label="分销商享受利益" prop="trigger">
          <div style="border:1px solid #ddd;padding: 0 20px 20px 20px" v-for="trigger in Add.data.form.formula.trigger">
              <div class="title">
                <span>{{trigger.title}}</span>
                <el-switch style="float:right;margin-top:12px;"
                  v-model="trigger.selected"
                  active-text="启用"
                  inactive-text="禁用">
                </el-switch>
              </div>
              <div style="border:1px solid #ddd;margin-top:10px;" v-for="item in trigger.items">
                
                <el-form-item v-if="item.type==1" :label="item.title" prop="condition">
                  <el-input :disabled="!trigger.selected" placeholder="" v-model="item.value" >
                  </el-input>
                </el-form-item>
                <el-form-item v-if="item.type==2" prop="condition">
                  <el-select :disabled="!trigger.selected"  v-model="item.value"  >
                    <el-option :label="'普通'" :value="1"></el-option>
                    <el-option  :label="'高级'" :value="2"></el-option>
                </el-select>
                </el-form-item>
                <el-form-item v-for="extra in item.extra"  :label="extra.title" :prop="extra.field">
                  <el-input :disabled="!trigger.selected"  v-model="extra.value" >
                  </el-input>
                </el-form-item>
              </div>
              
          </div>
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
      <el-form ref="form" :model="Edit.data.form" label-width="130px" :rules="Edit.data.rules">
				
        <el-form-item label="分销商名称" prop="title">
          <el-input v-model.trim="Edit.data.form.title" class="h-40 w-200" :maxlength="255" ></el-input>
        </el-form-item>

        <el-form-item label="分销商简介" prop="desc">
          <quill-editor 
              v-model="Edit.data.form.desc"
              ref="myQuillEditor"
              :options="Options">
              </quill-editor>
        </el-form-item>

        <el-form-item label="分销商图标" prop="logo">
         <el-upload
            class="avatar-uploader"
            :action="Edit.config.uploadUrl"
            :show-file-list="false"
            :on-success="handleAvatarSuccess"
            :before-upload="beforeAvatarUpload">
            <img v-if="Edit.data.form.logo" :src="config.ResourceBaseUrl + Edit.data.form.logo" class="avatar">
            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
          </el-upload>
        </el-form-item>

        <el-form-item label="成为分销商条件" prop="condition">
         <div style="border:1px solid #ddd;padding: 0 20px 20px 20px" v-for="conditon in Edit.data.form.formula.condition">
              <div class="title">
                <span>{{conditon.title}}</span>
                <el-switch style="float:right;margin-top:12px;"
                  v-model="conditon.selected"
                  active-text="启用"
                  inactive-text="禁用">
                </el-switch>
              </div>
              <div style="border:1px solid #ddd;margin-top:10px;" v-for="item in conditon.items">
                
                <el-form-item v-if="item.type==1" :label="item.title" prop="condition">
                  <el-input :disabled="!conditon.selected" v-model="item.value">
                  </el-input>
                </el-form-item>
                <el-form-item v-if="item.type==2"  :label="'请选择分成比例'" prop="condition">
                  <el-select :disabled="!conditon.selected" v-model="item.value"  >
                    <el-option :label="'普通'" :value="1"></el-option>
                    <el-option  :label="'高级'" :value="2"></el-option>
                </el-select>
                </el-form-item>
                <el-form-item v-for="extra in item.extra"  :label="extra.title" :prop="extra.field">
                  <el-input :disabled="!conditon.selected" v-model="extra.value" >
                  </el-input>
                </el-form-item>
              </div>
              
          </div>
        </el-form-item>

        <el-form-item label="分销商享受利益" prop="trigger">
          <div style="border:1px solid #ddd;padding: 0 20px 20px 20px" v-for="trigger in Edit.data.form.formula.trigger">
              <div class="title">
                <span>{{trigger.title}}</span>
                <el-switch style="float:right;margin-top:12px;"
                  v-model="trigger.selected"
                  active-text="启用"
                  inactive-text="禁用">
                </el-switch>
              </div>
              <div style="border:1px solid #ddd;margin-top:10px;" v-for="item in trigger.items">
                
                <el-form-item v-if="item.type==1" :label="item.title" prop="condition">
                  <el-input :disabled="!trigger.selected" v-model="item.value" >
                  </el-input>
                </el-form-item>
                <el-form-item v-if="item.type==2"  :label="'请选择分成比例'" prop="condition">
                  <el-select :disabled="!trigger.selected" v-model="item.value"  >
                    <el-option :label="'普通'" :value="1"></el-option>
                    <el-option  :label="'高级'" :value="2"></el-option>
                </el-select>
                </el-form-item>
                <el-form-item v-for="extra in item.extra"  :label="extra.title" :prop="extra.field">
                  <el-input :disabled="!trigger.selected" v-model="extra.value" >
                  </el-input>
                </el-form-item>
              </div>
              
          </div>
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
        baseApi: 'admin/MembersAgent'
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
            logo: null,
            title: null,
            desc:'',
            formula: {
              trigger:[],
              condition:[]
            }
          },
          rules: {
            title: [
              { required: true, message: "请输入分销商名称", trigger: "blur" }
            ],
            desc: [
              { required: true, message: "请输入分销商简介", trigger: "blur" }
            ],
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
            logo: null,
            title: null,
            desc:'',
            formula: {},
            formulas: {
              trigger:[],
              condition:[]
            }
          },
          rules: {
            title: [
              { required: true, message: "请输入分销商名称", trigger: "blur" }
            ],
            desc: [
              { required: true, message: "请输入分销商简介", trigger: "blur" }
            ],
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
      this.getTableData();
      this.getTrigger();
      this.getCondition()
    },
    getTrigger(){
        this.apiGet('/admin/MembersAgentDefaultJson?type=trigger').then(res => {
        this.handelResponse(res, data => {
          
          this.Add.data.form.formula.trigger =data
        })
      })
    },
    getCondition(){
        this.apiGet('/admin/MembersAgentDefaultJson?type=condition').then(res => {
        this.handelResponse(res, data => {
          
          this.Add.data.form.formula.condition = data
        })
      })
    },
    getTableData() {
      // 请求地址
      let that = this
      let url = this.config.baseApi
      this.apiGet(url).then(res => {
        this.handelResponse(res, data => {
          this.data.received.table = data.list
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
      this.Add.dialogFormVisible = true;
      this.Add.data.form.logo = '';
      this.Add.data.form.title = ''
      this.Add.data.form.desc = ''
    },
    edit(row) {
      this.Edit.data.primary = row.id;
      this.Edit.data.form = row;
      this.Edit.data.form.formulas = {}
      this.Edit.data.form.formulas.trigger = row.formula.trigger;
      this.Edit.data.form.formulas.condition = row.formula.condition;
      this.Edit.dialogFormVisible = true;
    },
    commitEdit(row){
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
      this.Add.data.form.logo = res.data;
      this.Edit.data.form.logo = res.data;
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
</style>
