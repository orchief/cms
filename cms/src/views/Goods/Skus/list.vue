<template>
<div>
			<!-- 头部 -->
		<div class="m-b-20 ovf-hd">
			<!-- 页面跳转 -->
			<div class="fl">
        <!-- <el-button type="primary" icon="document" @click="AddItems" v-if="!Add.disabled">新增</el-button> -->
			</div>
			<!-- 导出Excel表格 -->
			<downExcel :baseApi="config.baseApi" :config="config.excel" :tableData="data.received.table" :conditions="data.exchanged.search"></downExcel>
			<div>
				<!-- 搜索 -->
				<search-model :config="config.search" :data="data"></search-model>
			</div>
		</div>
		<!-- 头部 -->

		<!-- 内容 -->
		<transition name="fade" mode="out-in" appear>
			<table-model v-loading="showLoading" :Edit="Edit" :tableData="data.received.table" :config="config.table" :exchanged="data.exchanged" :baseApi="config.baseApi"></table-model>
    </transition>
		<!-- 内容 -->

		<!-- 底部 -->
		<div class="pos-rel p-t-20">
			<!-- 批量操作 -->
			<btnGroup  v-if="!config.table.noGroup"  :selectedData="data.exchanged.multipleSelection" :baseApi="config.baseApi" :config="config.btnGroup" :exchanged="data.exchange"></btnGroup>
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
import btnGroup from 'components/Common/btn-group.vue'
import downExcel from 'components/Common/down-excel.vue'
import tableModel from 'components/Common/table-modelUp.vue'
import searchModel from 'components/Common/search-model.vue'
import pageModel from 'components/Common/page-model.vue'

export default {
  components: {
    btnGroup,
    downExcel,
    tableModel,
    searchModel,
    pageModel
  },
  data() {
    return {
      Add: {
        dialogFormVisible: false,
        data: {
          primary: '',
          form: {
            ProductId: null,
            Stock: null,
            CostPrice: null,
            SalePrice: null,
            SkuImg: null,
            Weight: null,
            Content: null
          },
          selectData: []
        },
        config: {
          uploadUrl: axios.defaults.baseURL + 'admin/upload',
          domain: axios.defaults.baseURL,
          title: '新增1',
          form: {
            input: [
              { prop: 'ProductId', label: '商品id' },
              { prop: 'Stock', label: '库存' },
              { prop: 'CostPrice', label: '进货价' },
              { prop: 'MarketPrice', label: '市场价' },
              { prop: 'SalePrice', label: '销售价' },
              { prop: 'CashBack1', label: '一阶提成' },
              { prop: 'CashBack2', label: '二阶提成' },
              { prop: 'CashBack3', label: '三阶提成' },
              { prop: 'SkuImg', label: '商品规格对应图片' },
              { prop: 'Weight', label: '重量 (单位g)' },
              { prop: 'Content', label: '基本信息' }
            ],
            select: [],
            uploadImg: []
          },
          rules: {
            SkuImg: [{ required: true, message: '请输入商品规格对应图片' }],
            Content: [
              { required: true, message: '请输入商品规格基本信息' }
            ]
          }
        }
      },
      Edit: {
        dialogFormVisible: false,
        data: {
          primary: '',
          form: {
            Stock: null,
            CostPrice: null,
            SalePrice: null,
            SkuImg: null,
            Weight: null,
            Content: null,
            MarketPrice: null,
            CashBack1: null,
            CashBack2: null,
            CashBack3: null
          },
          selectData: []
        },
        config: {
          uploadUrl: axios.defaults.baseURL + 'admin/upload',
          domain: axios.defaults.baseURL,
          title: '编辑规格',
          form: {
            input: [
              { prop: 'Stock', label: '库存' },
              { prop: 'CostPrice', label: '进货价' },
              { prop: 'MarketPrice', label: '市场价' },
              { prop: 'SalePrice', label: '销售价' },
              { prop: 'CashBack1', label: '一阶提成' },
              { prop: 'CashBack2', label: '二阶提成' },
              { prop: 'CashBack3', label: '三阶提成' },
              { prop: 'Weight', label: '重量 (单位g)' },
              { prop: 'Content', label: '基本信息' }
            ],
            select: [],
            uploadImg: { prop: 'SkuImg', label: '商品规格对应图片' }
          },
          rules: {
            SkuImg: [{ required: true, message: '请输入商品规格对应图片' }],
            Content: [
              { required: true, message: '请输入关于该规格商品的基本信息' }
            ]
          }
        }
      },
      config: {
        baseApi: 'client/Skus',
        excel: {
          fileName: '1列表',
          tHeader: [
            '库存',
            '进货价',
            '销售价',
            '重量 (单位g)',
            '关于该规格商品的基本信息'
          ],
          filterVal: [
            'Stock',
            'CostPrice',
            'SalePrice',
            'Weight',
            'Content'
          ]
        },
        table: {
          noGroup: true,
          checkbox: false,
          status: false,
          sort: { field: 'custom' },
          show: {
            items: [
              '库存',
              '销量',
              '进货价',
              '市场价',
              '销售价',
              '一阶提成',
              '二阶提成',
              '三阶提成',
              '重量(g)',
              '关于该规格商品的基本信息'
            ],
            prop: [
              'Stock',
              'SalesVolume',
              'CostPrice',
              'MarketPrice',
              'SalePrice',
              'CashBack1',
              'CashBack2',
              'CashBack3',
              'Weight',
              'Content'
            ],
            width: [80, 80, 80, 80, 80, 80, 80, 80, 80, 200]
          },
          operate: { del: false, edit: true }
        },
        search: {
          search_input: [{ name: 'Stock', placeholder: '库存' }],
          search_select: []
        },
        page: {
          limits: [5, 10, 20, 50, 100],
          layout: 'total, sizes, prev, pager, next, jumper'
        }
      },
      data: {
        received: {
          table: [],
          count: null,
          search: {
            status: [
              { label: '启用', value: '1' },
              { label: '禁用', value: '0' }
            ]
          }
        },
        exchanged: {
          search: { limit: 5, page: 1, orderByString: '', ProductId: this.$route.params.id },
          multipleSelection: [],
          isDelete: 0
        }
      }
    }
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
  methods: {
    init() {
      // 基本数据获取
      this.tableData()
      this.getSelect()
    },
    AddItems() {
      this.Add.dialogFormVisible = true // 显示窗体
    },
    getSelect() {
      // let url = 'blog/ArticleTypes'
      // this.apiGet(url).then(res => {
      //   this.handelResponse(res, data => {
      //     data.list.map(function(i) {
      //       i.value = i.id
      //       i.label = i.typeName
      //     })
      //     console.log('data.list', data.list)
      //     this.Edit.data.selectData.type = data.list
      //     this.Add.data.selectData.type = data.list
      //   })
      // })
    },
    tableData() {
      // 表格数据
      const data = {
        params: this.getCondition()
      }
      // 请求地址
      let url = this.config.baseApi
      this.apiGet(url, data).then(res => {
        this.handelResponse(res, data => {
          this.data.received.table = data.list
          this.data.received.count = data.dataCount
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
      console.log(this.Add.data.form)
      this.$refs.form.validate(pass => {
        if (pass) {
          // 提交数据
          this.apiPost(this.config.baseApi, this.Add.data.form).then(res => {
            this.handelResponse(
              res,
              data => {
                _g.toastMsg('success', res.data)
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
    handleAvatarSuccess(res, file) {
      this.Add.data.form[this.Add.config.form.uploadImg.prop] = res.data
      // this.imageUrl =
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
