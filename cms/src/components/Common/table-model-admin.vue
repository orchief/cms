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
        <el-table-column type="expand" v-if="config.hidden">
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
            <el-table-column :sortable="config.sort[config.show.prop[i-1]]" :label="config.show.items[i-1]" :prop="config.show.prop[i-1]"	 :width="config.show.width[i-1]"></el-table-column>
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
                        <router-link :to="{ name: ''+lin.name, params: { id: scope.row.id }}" :title="lin.title">
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
      <el-form ref="form" :model="Edit.data.form" :rules="Edit.config.rules" label-width="130px">
        <!-- 普通输入类型 -->
        <el-form-item :label="item.label" :prop="item.prop" v-for="item in Edit.config.form.input">
          <el-input v-model.trim="Edit.data.form[item.prop]" class="h-40 w-200" :maxlength="255" ></el-input>
        </el-form-item>

        <el-form-item :label="item.label" :prop="item.prop" v-for="item in Edit.config.form.select">
          <el-select filterable v-model="Edit.data.form[item.prop]" :placeholder="item.placeholder" class="w-200">
            <el-option v-for="option in Edit.data.selectData[item.prop]" :label="option.label" :value="option.value"></el-option>
          </el-select>
        </el-form-item>

        <el-form-item :label="item.label" :prop="item.prop" v-for="item in Edit.config.form.multipleSelect">
          <el-select filterable v-model="Edit.data.form[item.prop]" :placeholder="item.placeholder" class="w-200" multiple>
            <el-option v-for="option in Edit.data.selectData[item.prop]" :label="option.label" :value="option.value"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="item.label" :prop="item.prop" v-for="(item,index) in Edit.config.form.textarea" :key="index" >
          <el-input v-model.trim="Edit.data.form[item.prop]" class="h-40 w-200" :maxlength="255" type="textarea"></el-input>
        </el-form-item>
        <!-- 图片上传 -->
        <el-form-item :label="this.Edit.config.form.uploadImg.label" v-if="this.Edit.config.form.uploadImg.label">
          <el-upload
          class="avatar-uploader"
          :action = "Edit.config.uploadUrl"
          :show-file-list="false"
          :on-success="handleAvatarSuccess"
          :before-upload="beforeAvatarUpload">
          <img v-if="Edit.data.form[this.Edit.config.form.uploadImg.prop]" :src="Edit.config.domain + Edit.data.form[this.Edit.config.form.uploadImg.prop]" class="avatar">
          <i v-else class="el-icon-plus avatar-uploader-icon"></i>
          </el-upload>
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
import http from "assets/js/http";
import cities from "assets/data/address.json";
export default {
  props: ["exchanged", "tableData", "config", "baseApi", "Edit"],
  data() {
    return {
      currentRow: null
    };
  },
  methods: {
    getCity() {
      // TODO 清除已有的市信息
      let tmp = {};
      // 获取省的数据
      if (this.Edit.data.form.province != "") {
        for (let i in cities[this.Edit.data.form.province]) {
          tmp.label = i;
          tmp.value = i;
          this.Edit.data.selectData.city[
            this.Edit.data.selectData.city.length
          ] = JSON.parse(JSON.stringify(tmp));
        }
      }
    },
    getHomwtown() {
      // TODO 清除已有的市信息
      this.Edit.data.selectData.hometown = [];
      let tmp = {};
      // 获取省的数据
      if (this.Edit.data.form.city != "") {
        for (let i in cities[this.Edit.data.form.province][
          this.Edit.data.form.city
        ]) {
          tmp.label =
            cities[this.Edit.data.form.province][this.Edit.data.form.city][i];
          tmp.value =
            cities[this.Edit.data.form.province][this.Edit.data.form.city][i];
          this.Edit.data.selectData.hometown[
            this.Edit.data.selectData.hometown.length
          ] = JSON.parse(JSON.stringify(tmp));
        }
      }
    },
    getClearCity() {
      // TODO 清除已有的市信息
      this.Edit.data.selectData.city = [];
      // this.Edit.data.form.city = "";
      let tmp = {};
      // 获取省的数据
      for (let i in cities[this.Edit.data.form.province]) {
        tmp.label = i;
        tmp.value = i;
        this.Edit.data.selectData.city[
          this.Edit.data.selectData.city.length
        ] = JSON.parse(JSON.stringify(tmp));
      }
    },
    inits() {
      // 监听省
      this.$watch("Edit.data.form.province", {
        deep: true,
        handler: function() {
          this.getClearCity();
        }
      });
      // 监听市
      this.$watch("Edit.data.form.city", {
        deep: true,
        handler: function() {
          this.getClearHomwtown();
        }
      });
    },
    getClearHomwtown() {
      this.Edit.data.form.hometown = "";
      // TODO 清除已有的市信息
      this.Edit.data.selectData.hometown = [];
      console.log(
        cities[this.Edit.data.form.province][this.Edit.data.form.city]
      );
      let tmp = {};
      // 获取省的数据
      for (let i in cities[this.Edit.data.form.province][
        this.Edit.data.form.city
      ]) {
        tmp.label =
          cities[this.Edit.data.form.province][this.Edit.data.form.city][i];
        tmp.value =
          cities[this.Edit.data.form.province][this.Edit.data.form.city][i];
        this.Edit.data.selectData.hometown[
          this.Edit.data.selectData.hometown.length
        ] = JSON.parse(JSON.stringify(tmp));
      }
    },
    getAddress() {
      console.log(
        "this.Edit.data.selectData.province",
        this.Edit.data.selectData.province
      );
      let tmp = {};
      // 获取省的数据
      for (let i in cities) {
        tmp.label = i;
        tmp.value = i;
        this.Edit.data.selectData.province[
          this.Edit.data.selectData.province.length
        ] = JSON.parse(JSON.stringify(tmp));
      }
    },
    /*commitEdit(row) {
      alert(111);
      let url = "home/adminUser";
      this.apiPost(url,this.Edit.data.form).then(res => {
      this.handelResponse(res, data => {
            console.log(res);
           // _g.toastMsg("success", "修改成功!");
           // this.exchanged.isDelete++;
            //this.Edit.dialogFormVisible = false;
        })
      })
    },*/
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
          this.loading_min = true;
          this.apidelete(this.baseApi + "/", item.id).then(res => {
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
      let url = "home/adminIndex";
      this.apiPost(url,row).then(res => {
      this.handelResponse(res, data => {
          this.Edit.data.form = data;
        })
      })
      //this.Edit.data.form = row;
      this.getAddress();
      this.getCity();
      this.getHomwtown();
      this.inits();
      this.Edit.dialogFormVisible = true;
    },
    getDefaultData(id) {
      let that = this;
      this.apiGet(this.baseApi + "/" + id).then(res => {
        this.handelResponse(res, data => {
          that.Edit.data.form = data;
          console.log(res);
        });
      });
    },
    dateFormat(row) {
      // 日期格式化
      var date = parseInt(row.create_time + "000");
      if (date === undefined) {
        return "";
      }
      return moment(date).format("YYYY年MM月DD日 HH:mm:ss");
    },
    handleAvatarSuccess(res, file) {
      console.log(res);
      this.Edit.data.form[this.Edit.config.form.uploadImg.prop] = res.data;
      // this.imageUrl =
    },
    beforeAvatarUpload(file) {
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
