<template>
	<div>
		<!-- 表格 -->
		<el-table :data="data.received.table" stripe="stripe" :border='true' v-loading="loading_min" element-loading-text="拼命加载中" style="width: 100%" @sort-change="sortChange">
			<!-- checkbox -->
			<!-- <el-table-column type="selection" width="50"></el-table-column> -->

			<el-table-column label="标题" prop="title"></el-table-column>
			<el-table-column label="赠送积分数量" prop="points"></el-table-column>
			<el-table-column label="备注" prop="remark"></el-table-column>
			<el-table-column label="是否开启" prop="statusTitle"></el-table-column>

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

		<!-- 编辑 -->
		<!-- 新增 -->
		<el-dialog title="编辑积分赠送事件" :visible.sync="Edit.dialogFormVisible" @close='Edit.dialogFormVisible = false'>
			<el-form ref="form" :model="Edit.data.form" label-width="130px">

				<el-form-item label="标题" prop="title">
					<el-input v-model.trim="Edit.data.form.title" class="h-40 w-200" :maxlength="255"></el-input>
				</el-form-item>

				<el-form-item label="赠送积分数量" prop="points">
					<el-input v-model.trim="Edit.data.form.points" class="h-40 w-200" :maxlength="255"></el-input>
				</el-form-item>

				<el-form-item label="备注" prop="remark">
					<el-input v-model.trim="Edit.data.form.remark" class="h-40 w-200" :maxlength="255"></el-input>
				</el-form-item>

				<el-form-item label="是否开启" prop="status">
          <el-radio-group v-model="Edit.data.form.status">
            <el-radio  :label="1">激活</el-radio>
					  <el-radio :label="0">禁用</el-radio>
          </el-radio-group>
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
      activeName: "first",
      productsCount: 0,
      products: {
        list: [],
        count: 0
      },
      config: {
        ResourceBaseUrl: window.ResourceBaseUrl,
        domain: window.axios.defaults.baseURL,
        baseApi: "admin/Point"
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
          finished: 0
        }
      };
      this.apiGet(url, data).then(res => {
        this.handelResponse(res, data => {
          data.list.map(function(i) {
            if (i.status == 1) {
              i.statusTitle = "激活";
            }
            if (i.status == 0) {
              i.statusTitle = "禁用";
            }
          });
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
      console.log(row)
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
              this.getTableData()
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
