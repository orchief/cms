<template>
  <div>
<el-form ref="form" :model="Add.data.form" label-width="130px">

        <el-form-item label="优惠券名称" prop="discountsId">
          <el-select v-model="Add.data.form.discountsId" placeholder="请选择优惠券">
            <el-option
              v-for="item in discounts"
              :key="item.value"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>

        <el-form-item label="用户名" prop="username">
          <el-input v-model.trim="Add.data.form.username" class="h-40 w-200" :maxlength="255"></el-input>
        </el-form-item>

        <el-form-item label="手机号" prop="phone">
          <el-input v-model.trim="Add.data.form.phone" class="h-40 w-200" :maxlength="255"></el-input>
        </el-form-item>

      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button type="primary" @click="commitAdd">发放</el-button>
      </div>

  </div>

</template>

<script>
import http from "assets/js/http.js";

export default {
  components: {},
  data() {
    return {
      discounts: null,
      selectedProducts: null,
      activeName: "third",
      productsCount: 0,
      products: {
        list: [],
        count: 0
      },
      config: {
        ResourceBaseUrl: window.ResourceBaseUrl,
        domain: window.axios.defaults.baseURL,
        baseApi: "admin/MembersDiscounts"
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
      let url = 'admin/GoodsDiscounts';
      let data = {
        params: {
          finished: 0,
          sendType: 1
        }
      };
      this.apiGet(url, data).then(res => {
        this.handelResponse(res, data => {
          data.list.map(function(i){
            i.label = i.discountName
            i.value = i.id
          })

          this.discounts = data.list
          console.log('discounts', this.discounts)
          // this.data.received.table = data.list;
          
          // this.data.received.count = data.dataCount;
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
