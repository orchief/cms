<template>
	<div>
		<!--
			更多验证规则需手动编辑条目 现在需要配置的部分包括 data config 以及自定义方法
		-->
		<!-- 面包屑 -->

		<div class="m-l-50 m-t-30 w-500">
			<el-form ref="form" :model="data.form" :rules="config.rules" label-width="130px">

				<!-- 普通输入类型 -->
				<el-form-item :label="item.label" :prop="item.prop" v-for="item in config.form.input">
					<el-input v-model.trim="data.form[item.prop]" class="h-40 w-200" :maxlength=12></el-input>
				</el-form-item>

				<!-- 单选类型 -->
				<el-form-item :label="item.label" :prop="item.prop" v-for="item in config.form.select">
					<el-select filterable v-model="data.form[item.prop]" :placeholder="item.placeholder" class="w-200">
					<el-option v-for="option in data.selectData[item.prop]" :label="option.label" :value="option.value"></el-option>
					</el-select>
				</el-form-item>

				<!-- 多选类型 -->
				<el-form-item :label="item.label" :prop="item.prop" v-for="item in config.form.multipleSelect">
					<el-select filterable v-model="data.form[item.prop]" :placeholder="item.placeholder" class="w-200" multiple>
						<el-option v-for="option in data.selectData[item.prop]" :label="option.label" :value="option.value"></el-option>
					</el-select>
				</el-form-item>

				<el-form-item>
					<el-button type="primary" @click="commit('form')" :loading="isLoading">提交</el-button>
					<el-button @click="goback()">返回</el-button>
				</el-form-item>
			</el-form>
		</div>
	</div>
</template>
<style type="text/css">
.form-checkbox:first-child {
  margin-left: 15px;
}
</style>
<script>
import http from 'assets/js/http'
import fomrMixin from 'assets/js/form_com'

export default {
  data() {
    return {
      data: {
        form: {
          name: '',
          orgcode: '',
          type: '',
          level: '',
          position: ''
        },
        selectData: {
          position: null,
          level: null
        }
      },
      config: {
        commitMsg: '添加成功',
        baseApi: 'admin/structures',
        crumb: [
          {
            to: '',
            name: '系统'
          },
          {
            to: '',
            name: '组织构架'
          },
          {
            to: '',
            name: '部门管理'
          }
        ],
        form: {
          input: [
            {
              prop: 'name',
              label: '单位名称'
            },
            {
              prop: 'orgcode',
              label: '组织代码'
            }
          ],
          select: [
            {
              prop: 'position',
              label: '坐落位置'
            },
            {
              prop: 'level',
              label: '级　　别'
            }
          ],
          multipleSelect: [
            {
              prop: 'type',
              label: '单位类型'
            }
          ]
        },
        rules: {
          name: [{ required: true, message: '请输入单位名称' }],
          orgcode: [{ required: true, message: '请输入组织机构代码' }],
          type: [{ required: true, message: '请输入单位类型' }],
          level: [{ required: true, message: '请选择级别' }],
          position: [{ required: true, message: '请选择坐落位置' }]
        }
      }
    }
  },
  created() {
    this.init()
  },
  methods: {
    init() {
      this.getType()
      this.getLevel()
      this.getPosition()
    },
    commit(form) {
      console.log('res = ', _g.j2s(this.data.form))
      this.$refs.form.validate(pass => {
        if (pass) {
          this.isLoading = !this.isLoading
          this.apiPost(this.config.baseApi, this.data.form).then(res => {
            this.handelResponse(
              res,
              data => {
                _g.toastMsg('success', this.config.commitMsg)
                _g.clearVuex('setUsers')
                setTimeout(() => {
                  this.goback()
                }, 1500)
              },
              () => {
                this.isLoading = !this.isLoading
              }
            )
          })
        }
      })
    },
    getType() {
      this.apiGet('admin/structureType').then(res => {
        this.handelResponse(res, data => {
          this.data.selectData.type = data.list
          console.log(data.list)
          this.data.selectData.type.map(function(value) {
            value.value = value.id
            value.label = value.type
            delete value.value.id
            delete value.value.type
          })
          console.log(this.data.selectData.type)
        })
      })
    },
    getLevel() {
      this.apiGet('admin/structureLevel').then(res => {
        this.handelResponse(res, data => {
          this.data.selectData.level = data.list
          this.data.selectData.level.map(function(value) {
            value.value = value.id
            value.label = value.level
            delete value.value.id
            delete value.value.level
          })
          console.log(this.data.selectData.level)
        })
      })
    },
    getPosition() {
      this.apiGet('admin/structurePosition').then(res => {
        this.handelResponse(res, data => {
          this.data.selectData.position = data.list
          this.data.selectData.position.map(function(value) {
            value.value = value.id
            value.label = value.position
            delete value.value.id
            delete value.value.position
          })
          console.log(this.data.selectData.position)
        })
      })
    }
  },
  mixins: [http, fomrMixin]
}
</script>