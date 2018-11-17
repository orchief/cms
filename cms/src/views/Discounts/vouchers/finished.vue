<template>
  <div>
    <!-- 头部 -->
    <div class="m-b-20 ovf-hd">
      <el-tabs v-model="activeName" @tab-click="jumpto">
        <el-tab-pane label="优惠券" name="first"></el-tab-pane>

        <el-tab-pane label="已结束优惠券" name="second"></el-tab-pane>

        <el-tab-pane label="领用/使用记录" name="third"></el-tab-pane>
      </el-tabs>
      <!-- 页面跳转 -->
      <div class="fl">
        <el-button type="primary" icon="document" @click="add()">新增优惠券</el-button>
      </div>
    </div>
    <!-- 头部 -->

    <!-- 表格 -->
    <el-table :data="data.received.table" stripe="stripe" :border='true' v-loading="loading_min" element-loading-text="拼命加载中" style="width: 100%" @sort-change="sortChange">
      <!-- checkbox -->
      <el-table-column type="selection" width="50"></el-table-column>

      <el-table-column label="优惠券名称" prop="discountName"></el-table-column>
      <el-table-column label="面值" prop="denomination"></el-table-column>
      <el-table-column label="订单满足金额" prop="orderTotalPayment"></el-table-column>
      <el-table-column label="使用期限开始日期" prop="startDate"></el-table-column>
      <el-table-column label="使用期限结束日期" prop="endDate"></el-table-column>
      <el-table-column label="领取限制" prop="discountLimit"></el-table-column>
      <el-table-column label="发放总量" prop="amount"></el-table-column>
      <el-table-column label="已领取" prop="receiveTimes"></el-table-column>
      <el-table-column label="已使用" prop="usedTimes"></el-table-column>

      <!-- 操作 -->
      <el-table-column label="操作">
        <template scope="scope">
          <span class="icon_button">
            <a href="javascript:;" @click="edit(scope.row)" title="编辑">
              <i class="el-icon-edit"></i>
            </a>
          </span>
          <!-- <span class="icon_button">
            <a href="javascript:;" @click="confirmDelete(scope.row)" title="删除">
              <i class="el-icon-delete"></i>
            </a>
          </span> -->
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
    <el-dialog title="新增优惠券" :visible.sync="Add.dialogFormVisible" @close='Add.dialogFormVisible = false'>
      <el-form ref="form" :model="Add.data.form" label-width="130px">

        <el-form-item label="优惠券名称" prop="discountName">
          <el-input v-model.trim="Add.data.form.discountName" class="h-40 w-200" :maxlength="255"></el-input>
        </el-form-item>

        <el-form-item label="面值" prop="denomination">
          <el-input v-model.trim="Add.data.form.denomination" class="h-40 w-200" :maxlength="255"></el-input>
        </el-form-item>

        <el-form-item label="使用条件(订单满)" prop="orderTotalPayment">
          <el-input v-model.trim="Add.data.form.orderTotalPayment" class="h-40 w-200" :maxlength="255"></el-input>
        </el-form-item>

        <!-- startDate -->
        <el-form-item label="有效期限" prop="startDate">
          <el-date-picker v-model="Add.data.form.startDate" type="datetime" placeholder="开始时间">
          </el-date-picker>
          <el-date-picker v-model="Add.data.form.endDate" type="datetime" placeholder="结束时间">
          </el-date-picker>
        </el-form-item>

        <el-form-item label="优惠券发放类型" prop="sendType">
          <el-radio v-model="Add.data.form.sendType" label="1">手工发送</el-radio>
          <el-radio v-model="Add.data.form.sendType" label="2">自助领取</el-radio>
        </el-form-item>

        <el-form-item label="发放总量" prop="amount">
          <el-input v-model.trim="Add.data.form.amount" class="h-40 w-200" :maxlength="255"></el-input>
        </el-form-item>

        <el-form-item label="每人限领" prop="discountLimit">
          <el-input v-model.trim="Add.data.form.discountLimit" class="h-40 w-200" :maxlength="255"></el-input>
        </el-form-item>

        <el-form-item label="活动商品" prop="products">
          <el-button @click="addProducts" type='primary'>部分商品参与 已选商品({{productsCount}})件</el-button>

        </el-form-item>

      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="Add.dialogFormVisible = false">取 消</el-button>
        <el-button type="primary" @click="commitAdd">确 定</el-button>
      </div>
    </el-dialog>
    <!-- 新增 -->

    <!-- 二次弹窗 -->
    <el-dialog title="自定义活动商品" :visible.sync="Add.dialogFormVisible2">

      <el-table ref="multipleTable" :data="products.list" tooltip-effect="dark" style="width: 100%" @selection-change="handleSelectionChange">
        <el-table-column type="selection" width="55">
        </el-table-column>
        <el-table-column label="商品名称" width="120">
          <template slot-scope="scope">{{ scope.row.productName }}</template>
        </el-table-column>
        <el-table-column label="商品货号" width="120">
          <template slot-scope="scope">{{ scope.row.productCode }}</template>
        </el-table-column>
        <el-table-column label="商品售价" width="120">
          <template slot-scope="scope">{{ scope.row.currentPrice }}</template>
        </el-table-column>

      </el-table>

      <div slot="footer" class="dialog-footer">
        <el-button @click="Add.dialogFormVisible2 = false">取 消</el-button>
        <el-button type="primary" @click="countProducts(row)">确 定</el-button>
      </div>
    </el-dialog>
    <!-- 二次弹窗 -->

    <!-- 编辑 -->
    <!-- 新增 -->
    <el-dialog title="新增优惠券" :visible.sync="Edit.dialogFormVisible" @close='Edit.dialogFormVisible = false'>
      <el-form ref="form" :model="Edit.data.form" label-width="130px">

        <el-form-item label="优惠券名称" prop="discountName">
          <el-input v-model.trim="Edit.data.form.discountName" class="h-40 w-200" :maxlength="255"></el-input>
        </el-form-item>

        <el-form-item label="面值" prop="denomination">
          <el-input v-model.trim="Edit.data.form.denomination" class="h-40 w-200" :maxlength="255"></el-input>
        </el-form-item>

        <el-form-item label="使用条件(订单满)" prop="orderTotalPayment">
          <el-input v-model.trim="Edit.data.form.orderTotalPayment" class="h-40 w-200" :maxlength="255"></el-input>
        </el-form-item>

        <!-- startDate -->
        <el-form-item label="有效期限" prop="startDate">
          <el-date-picker v-model="Edit.data.form.startDate" type="datetime" placeholder="开始时间">
          </el-date-picker>
          <el-date-picker v-model="Edit.data.form.endDate" type="datetime" placeholder="结束时间">
          </el-date-picker>
        </el-form-item>

        <el-form-item label="优惠券发放类型" prop="sendType">
          <el-radio v-model="Edit.data.form.sendType" label="1">手工发送</el-radio>
          <el-radio v-model="Edit.data.form.sendType" label="2">自助领取</el-radio>
        </el-form-item>

        <el-form-item label="发放总量" prop="amount">
          <el-input v-model.trim="Edit.data.form.amount" class="h-40 w-200" :maxlength="255"></el-input>
        </el-form-item>

        <el-form-item label="每人限领" prop="discountLimit">
          <el-input v-model.trim="Edit.data.form.discountLimit" class="h-40 w-200" :maxlength="255"></el-input>
        </el-form-item>

        <el-form-item label="活动商品" prop="products">
          <el-button @click="addProducts" type='primary'>部分商品参与 已选商品({{productsCount}})件</el-button>
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
        baseApi: "admin/GoodsDiscounts"
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
    },
    jumpto(url) {
      let jumpUrl = "";
      console.log("url", url.name);
      switch (url.name) {
        case "first":
          jumpUrl = "/cms/Discounts/vouchers";
          break;
        case "second":
          jumpUrl = "/cms/Discounts/vouchersfinished";
          break;
        case "third":
          jumpUrl = "/cms/Discounts/vouchersrecord";
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
          console.log("res", res);
          this.products.list = data.list;
          this.products.count = data.dataCount;
          console.log("this.products", this.products);
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
          finished: 1
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
      this.selectedProducts = row.products;

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
      console.log("res", res);
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
};
</script>

<style scoped>
.el-input,
.el-input__inner {
  width: auto;
}
</style>
