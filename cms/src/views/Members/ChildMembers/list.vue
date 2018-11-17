<template>
<div>
			<!-- 头部 -->
		<div class="m-b-20 ovf-hd">
			<!-- 页面跳转 -->
			<div class="fl">
        <el-button type="primary" icon="document" @click="AddItems" v-if="!Add.disabled">新增</el-button>
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
			<btnGroup  v-if="!config.table.noGroup"  :selectedData="data.exchanged.multipleSelection" :baseApi="config.baseApi" :config="config.table.btnGroup" :exchanged="data.exchange"></btnGroup>
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
import btnGroup from 'components/Common/btn-groupUp.vue'
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
        disabled: true,
        dialogFormVisible: false,
        data: {
          primary: '',
          form: {
            Code: null,
            Password: null,
            PasswordSalt: null,
            TradePassword: null,
            UserName: null,
            BirchDate: null,
            RealName: null,
            IdCard: null,
            Email: null,
            CellPhone: null,
            QQ: null,
            WeChat: null,
            OpenId: null
          },
          selectData: []
        },
        config: {
          uploadUrl: axios.defaults.baseUR + 'admin/upload',
          domain: axios.defaults.baseUR,
          title: '新增1',
          form: {
            input: [
              { prop: 'Code', label: '用户短信验证码(最大支持8位)' },
              { prop: 'Password', label: '密码' },
              { prop: 'PasswordSalt', label: '登录密码盐' },
              { prop: 'TradePassword', label: '交易密码' },
              { prop: 'UserName', label: '用户名' },
              { prop: 'BirchDate', label: '生日' },
              { prop: 'RealName', label: '真实姓名' },
              { prop: 'IdCard', label: '身份证号' },
              { prop: 'Email', label: '邮箱' },
              { prop: 'CellPhone', label: '手机号' },
              { prop: 'QQ', label: 'qq号' },
              { prop: 'WeChat', label: '微信号' },
              { prop: 'OpenId', label: '用户微信openid' }
            ],
            select: [],
            uploadImg: []
          },
          rules: {
            Password: [{ required: true, message: '请输入密码' }],
            PasswordSalt: [{ required: true, message: '请输入登录密码盐' }],
            TradePassword: [{ required: true, message: '请输入交易密码' }],
            UserName: [{ required: true, message: '请输入用户名' }],
            RealName: [{ required: true, message: '请输入真实姓名' }],
            IdCard: [{ required: true, message: '请输入身份证号' }],
            Email: [{ required: true, message: '请输入邮箱' }],
            CellPhone: [{ required: true, message: '请输入手机号' }],
            QQ: [{ required: true, message: '请输入qq号' }],
            WeChat: [{ required: true, message: '请输入微信号' }],
            OpenId: [{ required: true, message: '请输入用户微信openid' }]
          }
        }
      },
      Edit: {
        dialogFormVisible: false,
        data: {
          primary: '',
          form: {
            Code: null,
            Password: null,
            PasswordSalt: null,
            TradePassword: null,
            UserName: null,
            BirchDate: null,
            RealName: null,
            IdCard: null,
            Email: null,
            CellPhone: null,
            QQ: null,
            WeChat: null,
            OpenId: null
          },
          selectData: []
        },
        config: {
          uploadUrl: axios.defaults.baseUR + 'admin/upload',
          domain: axios.defaults.baseUR,
          title: '编辑用户信息',
          form: {
            input: [
              { prop: 'CellPhone', label: '手机号' } // 暂时只能重置手机号  一般这里什么都不能修改
            ],
            select: [],
            uploadImg: []
          },
          rules: {
            Password: [{ required: true, message: '请输入密码' }],
            PasswordSalt: [{ required: true, message: '请输入登录密码盐' }],
            TradePassword: [{ required: true, message: '请输入交易密码' }],
            UserName: [{ required: true, message: '请输入用户名' }],
            RealName: [{ required: true, message: '请输入真实姓名' }],
            IdCard: [{ required: true, message: '请输入身份证号' }],
            Email: [{ required: true, message: '请输入邮箱' }],
            CellPhone: [{ required: true, message: '请输入手机号' }],
            QQ: [{ required: true, message: '请输入qq号' }],
            WeChat: [{ required: true, message: '请输入微信号' }],
            OpenId: [{ required: true, message: '请输入用户微信openid' }]
          }
        }
      },
      config: {
        baseApi: 'client/Members',
        excel: {
          fileName: '用户列表',
          tHeader: [
            '用户名',
            '注册时间',
            '账户余额',
            '总消费',
            '总积分',
            '生日',
            '真实姓名',
            '身份证号',
            '邮箱',
            '手机号',
            'qq号',
            '微信号'
          ],
          filterVal: [
            'UserName',
            'CreateDate',
            'Balance',
            'Expend',
            'Points',
            'BirchDate',
            'RealName',
            'IdCard',
            'Email',
            'CellPhone',
            'QQ',
            'WeChat'
          ]
        },
        table: {
          btnGroup: [
            {
              title: '解冻',
              loading: 'enableLoading',
              size: 'small',
              param: 1
            },
            {
              title: '冻结',
              loading: 'disableLoading',
              size: 'small',
              param: 0
            }
          ],
          noGroup: false,
          checkbox: true,
          status: false,
          sort: { field: 'custom' },
          show: {
            prop: [
              'UserName',
              'CellPhone',
              'CreateDate',
              'Balance',
              'Expend',
              'Points',
              'Enabled'
            ],
            items: [
              '用户名',
              '手机号',
              '注册时间',
              '账户余额',
              '总消费',
              '总积分',
              '状态'
            ],
            width: [150, 108, 155, 100]
          },
          hidden: {
            items: [
              '生日',
              '真实姓名',
              '身份证号',
              '邮箱',
              'qq号',
              '微信号',
              '推荐人账户',
              '推荐人手机'
            ],
            prop: [
              'BirchDate',
              'RealName',
              'IdCard',
              'Email',
              'QQ',
              'WeChat',
              'ReferUserName',
              'ReferCellPhone'
            ]
          },
          operate: {
            del: false,
            edit: true,
            link: [
              {
                name: '子用户管理',
                title: '子用户管理',
                class: 'directlyChild',
                svg: true
              },
              {
                name: '地址管理',
                title: '地址',
                class: 'address',
                svg: true
              },
              {
                name: '银行卡',
                title: '银行卡',
                class: 'bank',
                svg: true
              },
              {
                name: '余额记录',
                title: '余额记录',
                class: 'rewardRecord',
                svg: true
              }
            ]
          }
        },
        search: {
          search_input: [
            { name: 'UserName', placeholder: '用户名' },
            { name: 'RealName', placeholder: '真实姓名' },
            { name: 'CellPhone', placeholder: '手机号' },
            { name: 'Email', placeholder: '邮箱' },
            { name: 'QQ', placeholder: 'QQ号' }
          ],
          search_select: [{ name: 'Enabled', placeholder: '用户状态' }]
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
            Enabled: [
              { label: '可用', value: '1' },
              { label: '冻结', value: '0' }
            ]
          }
        },
        exchanged: {
          search: { limit: 5, page: 1, orderByString: '', ReferUserId: this.$route.params.id },
          multipleSelection: [],
          isDelete: 0
        }
      }
    }
  },
  created() {
    console.log(this.$route.params.id)
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
    this.$watch('$route.params.id', {
      deep: true,
      handler: function() {
        this.data.exchanged.search.ReferUserId = this.$route.params.id
        router.push({ path: this.$route.path, query: this.getCondition() })
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
          data.list.map(function(i) {
            if (i.Enabled === 0) {
              i.Enabled = '冻结'
            }
            if (i.Enabled === 1) {
              i.Enabled = '可用'
            }
          })
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
