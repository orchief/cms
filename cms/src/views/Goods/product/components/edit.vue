<template>
<div>
         <el-table
            :data="tableData"
            stripe="stripe"
            :border='true'
            v-loading="loading_min"
            element-loading-text="拼命加载中"
            style="width: 100%"
            @sort-change="sortChange"
            @selection-change="selectItem"
    >
        <!-- checkbox -->
        <el-table-column type="selection" 	v-if="config.checkbox"	 width="50"></el-table-column>

        <!-- 隐藏内容 可配置是否以及内容-->
        <el-table-column type="expand" v-if="config.hidden.items.length">
            <template scope="props">
                <el-form label-position="left" inline class='demo-table-expand'>
                    <el-form-item :label="config.hidden.items[i-1]" v-for="i in config.hidden.items.length">
                        <span>{{ props.row[config.hidden.prop[i-1]] }}</span>
                    </el-form-item>
                </el-form>
            </template>
        </el-table-column>

        <!-- 表格主体 -->
        <template v-for="i in config.show.items.length" >
            <template v-if="config.show.type && config.show.type[i-1] == 'img'" >
              <el-table-column  :label="config.show.items[i-1]" :prop="config.show.prop[i-1]"	 :width="config.show.width[i-1]">
                <template slot-scope="scope">
                  <img :src="ResourceBaseUrl+scope.row[config.show.prop[i-1]]" :alt="ResourceBaseUrl+scope.row[config.show.prop[i-1]]" style="height:200px;width:200px">
                </template>
              </el-table-column>
            </template>
            <template v-else>
              <el-table-column :sortable="config.sort[config.show.prop[i-1]]" :label="config.show.items[i-1]" :prop="config.show.prop[i-1]"	 :width="config.show.width[i-1]"></el-table-column>
            </template>
        </template>
        
        <!-- 内容过长的内容 -->
        <template  v-if="config.toolong">
            <el-table-column
                    v-for="i in config.toolong.items.length" 		:label="config.toolong.items[i-1]" 	:prop="config.toolong.prop[i-1]"  :width="config.toolong.width[i-1]"
                    >
                <template scope="scope">
                    <el-popover trigger="hover" placement="top">
                        <p v-html="scope.row[config.toolong.prop[i-1]]"></p>
                        <div slot="reference" class="name-wrapper">
                            <el-tag>{{config.toolong.items[i-1]}}详情</el-tag>
                        </div>
                    </el-popover>
                </template>
            </el-table-column>
        </template>
        <!-- 内容过长的内容 -->

        <!-- 状态 -->
        <el-table-column label="状态" width="100" v-if="config.status">
            <template scope="scope">
                <div>
                    {{ scope.row.status | status }}
                </div>
            </template>
        </el-table-column>
        <!-- 操作 -->
        <el-table-column label="操作" v-if="config.operate" :width="config.operate.width">
            <template scope="scope">
                <div>
                    <template v-if="config.operate.link" v-for="lin in config.operate.link">
                    <el-tooltip class="icon_button" effect="dark" :content="lin.title" placement="top">
                        <router-link :to="{ name: ''+lin.name, params: { id: scope.row.id },query:{id:scope.row.id}}" :title="lin.title">
                        <template v-if="lin.svg">
                            <icon  :class="lin.class+'-icon'" :name="lin.class"></icon>
                        </template>
                        <template v-else>
      						      <i :class="lin.class"></i>
                        </template>
  						          </router-link>
				          </el-tooltip>
                    </template>
                    <span  class="icon_button" v-if="config.operate.edit">
                        <a href="javascript:;" @click="edit(scope.row)" title="编辑">
                            <i  class="el-icon-edit"></i>
                        </a>
                    </span>
                    <span  class="icon_button" v-if="config.operate.del">
                        <a href="javascript:;" @click="confirmDelete(scope.row)" title="删除">
                            <i  class="el-icon-delete"></i>
                        </a>
                    </span>
                </div>
            </template>
        </el-table-column>
    </el-table>
    <!-- 编辑 -->
    <el-dialog :title="Edit.config.title" :visible.sync="Edit.dialogFormVisible">
      <el-form ref="form" :model="Edit.data.form" :rules="Edit.config.rules" :label-width="Edit.config.width ? Edit.config.width : '160px'">
        <!-- 普通输入类型 -->

        <template v-for="item in Edit.config.form">
            <!-- input -->
            <el-form-item v-if="item.type == 'input'" :label="item.label" :prop="item.prop">
              <el-input v-model.trim="Edit.data.form[item.prop]" :class="item.class || 'h-40 w-200'" :maxlength="item.maxlength || 255" ></el-input>
            </el-form-item>
            <!-- input -->

            <!-- input -->
            <el-form-item v-if="item.type == 'richtext'" :label='item.label'>
              <quill-editor 
              v-model="Edit.data.form[item.prop]"
              ref="myQuillEditor"
              :options="Options"
              >
              </quill-editor>
            </el-form-item>
            <!-- input -->
            
            <!-- select -->
            <el-form-item v-if="item.type == 'select'" :label="item.label" :prop="item.prop">
              <el-select filterable v-model="Edit.data.form[item.prop]" :placeholder="item.placeholder" :class="item.class || 'h-40 w-200'">
                <template v-if="item.default">
                  <el-option v-for="option in item.default" :label="option.label" :value="option.value"></el-option>
                </template>
                <template else>
                  <el-option v-for="option in Edit.data.selectData[item.prop]" :label="option.label" :value="option.value"></el-option>
                </template>
              </el-select>
            </el-form-item>
            <!-- select -->

            <!-- multipleSelect -->
            <el-form-item v-if="item.type == 'multipleSelect'" :label="item.label" :prop="item.prop">
              <el-select filterable v-model="Edit.data.form[item.prop]" :placeholder="item.placeholder" :class="item.class || 'h-40 w-200'">
                <el-option v-for="option in Edit.data.selectData[item.prop]" :label="option.label" :value="option.value"></el-option>
              </el-select>
            </el-form-item>
            <!-- multipleSelect -->

            <!-- datetime -->
            <el-form-item v-if="item.type == 'datetime'" :label="item.label" :prop="item.prop" >
                <el-date-picker
                v-model="Edit.data.form[item.prop]"
                :placeholder="item.placeholder"
                type="datetime"
                >
              </el-date-picker>
            </el-form-item>
            <!-- datetime -->

          <!-- 图片1 -->
            <el-form-item v-if="item.type == 'img'" :label="item.label">
              <el-upload
              class="avatar-uploader"
              :action="Edit.config.uploadUrl"
              :show-file-list="false"
              :on-success="handleAvatarSuccess1"
              :before-upload="beforeAvatarUpload1">
              <img v-if="Edit.data.form[item.prop]" :src="Edit.config.domain + Edit.data.form[item.prop]" class="avatar">
              <i v-else class="el-icon-plus avatar-uploader-icon"></i>
              </el-upload>
            </el-form-item>
          <!-- 图片1 -->

          <!-- 图片2 -->
          <el-form-item v-if="item.type == 'img2'" :label="item.label">
              <el-upload
              class="avatar-uploader"
              :action="Edit.config.uploadUrl"
              :show-file-list="false"
              :on-success="handleAvatarSuccess2"
              :before-upload="beforeAvatarUpload2">
              <img v-if="Edit.data.form[item.prop]" :src="Edit.config.domain + Edit.data.form[item.prop]" class="avatar">
              <i v-else class="el-icon-plus avatar-uploader-icon"></i>
              </el-upload>
            </el-form-item>
          <!-- 图片2 -->
        </template>  

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
import http from "assets/js/http";
export default {
  props: ["exchanged", "tableData", "config", "baseApi", "Edit"],
  data() {
    return {
      currentRow: null
    };
  },
  methods: {
    commitEdit(row){
      this.$refs.form.validate(pass => {
        if (pass) {
          this.apiPut(
            this.baseApi + "/",
            this.Edit.data.primary,
            this.Edit.data.form
          ).then(res => {
            this.handelResponse(res, data => {
              this.tableData[0] = this.Edit.data.form;
              this.exchanged.isDelete++;
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
      console.log('val', val)
      this.exchanged.multipleSelection = val;
    },
    confirmDelete(item) {
      console.log('item', item)
      this.$confirm("确认删除?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          this.loading_min = true;
          this.apiDelete(this.baseApi + "/", item.id).then(res => {
            this.loading_min = false;
            const that = this;
            this.handelResponse(res, data => {
              that.exchanged.isDelete++;
              this.loading_min = false;
              _g.toastMsg("success", "删除成功");
            });
          });
        })
        .catch(() => {
          // catch error
        });
    },
    edit(row) {
      this.Edit.data.primary = row.id;
      this.Edit.data.form = row;
      this.Edit.dialogFormVisible = true;
    },
    handleAvatarSuccess1(res){
      console.log(res)
      let that = this
      this.Edit.config.form.map(function(i){
        if(i.type == 'img'){
          that.Edit.data.form[i.prop] = res.data
        }
      })
    },
    handleAvatarSuccess2(res){
      console.log(res)
      let that = this
      this.Edit.config.form.map(function(i){
        if(i.type == 'img2'){
          that.Edit.data.form[i.prop] = res.data
        }
      })
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
    }

  },
  created() {},
  mixins: [http]
};
</script>

<style>
.demo-table-expand {
  font-size: 0;
}
.demo-table-expand label {
  color: #99a9bf;
}
.demo-table-expand .el-form-item {
  margin-right: 0;
  margin-bottom: 0;
  width: 50%;
}
</style>
