<template>
    <div> 
       <div>好友砍价商品不同时享受满减活动,不能使用优惠劵,不能使用积分抵扣订单金额</div>
        <!-- 页面跳转 -->
        <el-button type="primary" icon="document" @click="add()">新建砍价</el-button>
        <!-- 头部 -->
        <div class="m-b-20 ovf-hd">

            <div class="fl">
                <el-tabs v-model="activeName" @tab-click="jumpto">
                    <el-tab-pane label="所有活动" name="first"></el-tab-pane>

                    <el-tab-pane label="进行中" name="second"></el-tab-pane>

                    <el-tab-pane label="未开始" name="third"></el-tab-pane>

                    <el-tab-pane label="已结束" name="fouth"></el-tab-pane>
                </el-tabs>
            </div>
        </div>
        <!-- 头部 -->

        <!-- 表格 -->
        <el-table :data="data.received.table" stripe="stripe" :border='true' v-loading="loading_min" element-loading-text="拼命加载中" style="width: 100%" @sort-change="sortChange">
            <!-- checkbox -->
            <el-table-column type="selection" width="50"></el-table-column>

            <el-table-column label="商品名称" prop="title"></el-table-column>
            <el-table-column label="初始底价" prop="startPrice"></el-table-column>
            <el-table-column label="商品底价" prop="bottomPrice"></el-table-column>
            <el-table-column label="活动开始日期" prop="startDate"></el-table-column>
            <el-table-column label="活动结束日期" prop="endDate"></el-table-column>
            <el-table-column label="活动库存" prop="amount"></el-table-column>
            <el-table-column label="成交数量" prop="saleNum"></el-table-column>
            <el-table-column label="活动状态" prop="status"></el-table-column>

            <!-- 操作 -->
            <el-table-column label="操作">
                <template scope="scope">
                    <span class="icon_button">
                        <a href="javascript:;" @click="edit(scope.row)" title="编辑">
                            <i class="el-icon-edit"></i>
                        </a>
                    </span>

                    <span class="icon_button">
                        <a href="javascript:;" @click="confirmDelete(scope.row)" title="删除">
                            <i class="el-icon-delete"></i>
                        </a>
                    </span>
                </template>
            </el-table-column>
        </el-table>
        <!-- 表格 -->
        <div class="pos-rel p-t-20">
            <!-- <el-pagination
        @size-change="handlePageLimit"
        @current-change="handlePageChange"
        :current-page="currentPage"
        :page-sizes="config.limits"
        :page-size="limit"
        :layout="config.layout"
        :total="dataCount">
      </el-pagination> -->
        </div>

        <!-- 新增 -->
        <el-dialog title="新建砍价" :visible.sync="Add.dialogFormVisible" @close='Add.dialogFormVisible = false'>
            <el-form ref="form" :model="Add.data.form" label-width="130px">

                <el-form-item label="分享标题" prop="title">
                    <el-input v-model.trim="Add.data.form.title" class="h-40 w-200" :maxlength="255"></el-input>
                </el-form-item>

                <!-- startDate -->
                <el-form-item label="活动时间" prop="startDate">
                    <el-date-picker v-model="Add.data.form.startDate" type="datetime" placeholder="开始时间">
                    </el-date-picker>
                    <el-date-picker v-model="Add.data.form.endDate" type="datetime" placeholder="结束时间">
                    </el-date-picker>
                </el-form-item>

                <el-form-item label="活动封面" prop="path">
                <el-upload
                    class="avatar-uploader"
                    :action="Add.config.uploadUrl"
                    :show-file-list="false"
                    :on-success="handleAvatarSuccess"
                    :before-upload="beforeAvatarUpload">
                    <img v-if="Add.data.form.backgroundImg" :src="config.ResourceBaseUrl + Add.data.form.backgroundImg" class="avatar">
                    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                </el-upload>
                </el-form-item>

                <el-form-item label="活动说明" prop="desc">
                <quill-editor 
                    v-model="Edit.data.form.desc"
                    ref="myQuillEditor"
                    :options="Options">
                    </quill-editor>
                </el-form-item>

                <el-form-item label="选择商品" prop="productId">
                    <el-select v-model="Add.data.form.productId" :placeholder="'选择商品'" class="w-200">
                        <el-option v-for="product in products.list" :label="product.productName" :value="product.id"></el-option>
                    </el-select>
                </el-form-item>

                <el-form-item label="活动库存" prop="amount">
                    <el-input v-model.trim="Add.data.form.amount" class="h-40 w-200" :maxlength="255"></el-input>
                </el-form-item>

                <el-form-item label="限购数量" prop="discountLimit">
                    <el-input v-model.trim="Add.data.form.discountLimit" class="h-40 w-200" :maxlength="255"></el-input>
                </el-form-item>

                <el-form-item label="初始价格" prop="startPrice">
                    <el-input v-model.trim="Add.data.form.startPrice" class="h-40 w-200" :maxlength="255"></el-input>
                </el-form-item>

                <el-form-item label="活动底价" prop="bottomPrice">
                    <el-input v-model.trim="Add.data.form.bottomPrice" class="h-40 w-200" :maxlength="255"></el-input>
                </el-form-item>

                <el-form-item label="砍价方式" prop="bargainType">
                    <el-radio v-model="Add.data.form.bargainType" label="1">固定值</el-radio>
                     每　　次
                    <el-input v-model.trim="Add.data.form.bargainPrice" class="h-40 w-110" :maxlength="255"></el-input>
                    <br>
                    <el-radio v-model="Add.data.form.bargainType" label="2">随　机</el-radio>
                   随机砍掉
                    <el-input v-model.trim="Add.data.form.bargainMinPrice" class="h-40 w-110" :maxlength="255"></el-input>-
                    <el-input v-model.trim="Add.data.form.bargainMaxPrice" class="h-40 w-110" :maxlength="255"></el-input>
                </el-form-item>

            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="Add.dialogFormVisible = false">取 消</el-button>
                <el-button type="primary" @click="commitAdd">确 定</el-button>
            </div>
        </el-dialog>
        <!-- 新增 -->

        <!-- 编辑 -->
        <!-- 新增 -->
        <el-dialog title="新增优惠券" :visible.sync="Edit.dialogFormVisible" @close='Edit.dialogFormVisible = false'>
            <el-form ref="form" :model="Edit.data.form" label-width="130px">

                
                <el-form-item label="分享标题" prop="title">
                    <el-input v-model.trim="Edit.data.form.title" class="h-40 w-200" :maxlength="255"></el-input>
                </el-form-item>

                <!-- startDate -->
                <el-form-item label="活动时间" prop="startDate">
                    <el-date-picker v-model="Edit.data.form.startDate" type="datetime" placeholder="开始时间">
                    </el-date-picker>
                    <el-date-picker v-model="Edit.data.form.endDate" type="datetime" placeholder="结束时间">
                    </el-date-picker>
                </el-form-item>

                <el-form-item label="活动封面" prop="path">
                <el-upload
                    class="avatar-uploader"
                    :action="Edit.config.uploadUrl"
                    :show-file-list="false"
                    :on-success="handleAvatarSuccess"
                    :before-upload="beforeAvatarUpload">
                    <img v-if="Edit.data.form.backgroundImg" :src="config.ResourceBaseUrl + Edit.data.form.backgroundImg" class="avatar">
                    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                </el-upload>
                </el-form-item>

                <el-form-item label="活动说明" prop="desc">
                <quill-editor 
                    v-model="Edit.data.form.desc"
                    ref="myQuillEditor"
                    :options="Options">
                    </quill-editor>
                </el-form-item>

                <el-form-item label="选择商品" prop="productId">
                    <el-select v-model="Edit.data.form.productId" :placeholder="'选择商品'" class="w-200">
                        <el-option v-for="product in products.list" :label="product.productName" :value="product.id"></el-option>
                    </el-select>
                </el-form-item>

                <el-form-item label="活动库存" prop="amount">
                    <el-input v-model.trim="Edit.data.form.amount" class="h-40 w-200" :maxlength="255"></el-input>
                </el-form-item>

                <el-form-item label="限购数量" prop="discountLimit">
                    <el-input v-model.trim="Edit.data.form.discountLimit" class="h-40 w-200" :maxlength="255"></el-input>
                </el-form-item>

                <el-form-item label="初始价格" prop="startPrice">
                    <el-input v-model.trim="Edit.data.form.startPrice" class="h-40 w-200" :maxlength="255"></el-input>
                </el-form-item>

                <el-form-item label="活动底价" prop="bottomPrice">
                    <el-input v-model.trim="Edit.data.form.bottomPrice" class="h-40 w-200" :maxlength="255"></el-input>
                </el-form-item>

                <el-form-item label="砍价方式" prop="bargainType">
                    <el-radio v-model="Edit.data.form.bargainType" label="1">固定值</el-radio>
                     每　　次
                    <el-input v-model.trim="Edit.data.form.bargainPrice" class="h-40 w-110" :maxlength="255"></el-input>
                    <br>
                    <el-radio v-model="Edit.data.form.bargainType" label="2">随　机</el-radio>
                   随机砍掉
                    <el-input v-model.trim="Edit.data.form.bargainMinPrice" class="h-40 w-110" :maxlength="255"></el-input>-
                    <el-input v-model.trim="Edit.data.form.bargainMaxPrice" class="h-40 w-110" :maxlength="255"></el-input>
                </el-form-item>

            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="Edit.dialogFormVisible = false">取 消</el-button>
                <el-button type="primary" @click="commitEdit">确 定</el-button>
            </div>
        </el-dialog>
        <!-- 新增 -->
        <!-- 编辑 -->

    </div>

</template>

<script>
import http from "assets/js/http.js";

export default {
  components: {},
  data() {
    return {
      selectedProducts: null,
      activeName: "second",
      productsCount: 0,
      products: {
        list: [],
        count: 0
      },
      config: {
        ResourceBaseUrl: window.ResourceBaseUrl,
        domain: window.axios.defaults.baseURL,
        baseApi: "admin/GoodsBargain"
      },
      data: {
        received: {
          table: null
        }
      },
      Add: {
        config: {
          uploadUrl: window.axios.defaults.baseURL + "admin/upload"
        },
        dialogFormVisible: false,
        dialogFormVisible2: false,
        data: {
          form: {
            uri: null,
            path: null
          }
        }
      },
      Edit: {
        config: {
          uploadUrl: window.axios.defaults.baseURL + "admin/upload"
        },
        dialogFormVisible: false,
        data: {
          form: {
            uri: null,
            path: null
          }
        }
      }
    };
  },
  created() {
    this.init();
  },
  methods: {
    init() {
      // 基本数据获取
      this.getTableData();
      this.addProducts();
    },
    jumpto(url) {
      let jumpUrl = "";
      console.log("url", url.name);
      switch (url.name) {
        case "first":
          jumpUrl = "/cms/Discounts/cut";
          break;
        case "second":
          jumpUrl = "/cms/Discounts/cutStart";
          break;
        case "third":
          jumpUrl = "/cms/Discounts/cutUnstart";
          break;
        case "fouth":
          jumpUrl = "/cms/Discounts/cutClose";
          break;
      }
      router.push({ path: jumpUrl });
    },
    handleSelectionChange(val) {
      this.selectedProducts = val;
      // TODO 获得productSId
      let that = this;
      that.Add.data.form.products = [];
      for (let i in val) {
        that.Add.data.form.products[that.Add.data.form.products.length] =
          val[i].id;
      }
    },
    countProducts() {
      // TODO 统计选中的商品总数
      this.productsCount = this.Add.data.form.products.length;
      this.Add.dialogFormVisible2 = false;
    },
    addProducts() {
      // TODO 获取商品列表
      this.apiGet("admin/GoodsProducts").then(res => {
        this.handelResponse(res, data => {
          this.products.list = data.list;
          this.products.count = data.dataCount;
          this.selectedProducts.map(selpro => {
            this.products.list.map(pro => {
              if (selpro.id == pro.id) {
                this.$nextTick(() => {
                  this.$refs.multipleTable.toggleRowSelection(pro, true);
                });
              }
            });
          });
        });
      });
      //
      this.Add.dialogFormVisible2 = true;
    },
    getTableData() {
      // 请求地址
      let that = this;
      let url = this.config.baseApi;
      let data = {
        params: {
          status: 1
        }
      };
      this.apiGet(url, data).then(res => {
        this.handelResponse(res, data => {
          this.data.received.table = data.list;
          this.data.received.count = data.dataCount;
        });
      });
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
                _g.toastMsg("success", res.data.msg);
                console.log("this", this);
                this.Add.dialogFormVisible = false; // 显示窗体
              },
              () => {
                this.isLoading = !this.isLoading;
              }
            );
          });
        }
      });
    },
    add() {
      this.Add.dialogFormVisible = true;
    },
    edit(row) {
      this.Edit.data.primary = row.id;
      this.Edit.data.form = row;
      this.Edit.dialogFormVisible = true;
    },
    commitEdit(row) {
      this.$refs.form.validate(pass => {
        if (pass) {
          this.apiPut(
            this.config.baseApi + "/",
            this.Edit.data.primary,
            this.Edit.data.form
          ).then(res => {
            this.handelResponse(res, data => {
              _g.toastMsg("success", "编辑成功");
              this.getTableData();
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
          _g.openGlobalLoading();
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
      this.Add.data.form.backgroundImg = res.data;
      this.Edit.data.form.backgroundImg = res.data;
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
};
</script>

<style scoped>
.el-input,
.el-input__inner {
  width: auto;
}
</style>
