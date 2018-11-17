<template>
	<div>
		<div class="m-l-50 m-t-30 w-500">
			<el-form ref="form" :model="form" :rules="rules" label-width="130px">
				<el-form-item label="用户名" prop="username">
					<el-input v-model.trim="form.username" class="h-40 w-200" :maxlength=12></el-input>
				</el-form-item>
				<el-form-item label="密码" prop="password">
					<el-input v-model.trim="form.password" class="h-40 w-200" type="password" :maxlength=12></el-input>
				</el-form-item>
        <el-form-item label="确认密码" prop="repass">
					<el-input v-model.trim="form.repass" class="h-40 w-200" type="password" :maxlength=12></el-input>
				</el-form-item>
				<el-form-item label="备注">
					<el-input v-model.trim="form.remark" class="h-40 w-200"></el-input>
				</el-form-item>
				<el-form-item label="用户组">
					<el-checkbox-group v-model="selectedGroups">
						<el-checkbox v-for="item in groupOptions" :label="item.title" class="form-checkbox"></el-checkbox>
					</el-checkbox-group>
				</el-form-item>
				<el-form-item>
					<el-button type="primary" @click="add('form')" :loading="isLoading">提交</el-button>
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
    const validateUsername = (rule, value, callback) => {
      if (!value) {
        return callback(new Error('用户名不能为空'))
      }
      const re = /[^\u0000-\u00FF]+/
      const res = re.test(value)
      console.log(res)
      if (res) {
        callback(new Error('用户名只能包含半角，字母加数字'))
      }
      if (value.length < 6) {
        callback(new Error('用户名长度为最小为6位'))
      }
      callback()
    }
    const validatePassword = (rule, value, callback) => {
      if (!value) {
        return callback(new Error('密码不能为空'))
      }
      const re = /[^\u0000-\u00FF]+/
      const res = re.test(value)
      console.log(res)
      if (res) {
        callback(new Error('密码只能包含半角字符，字母加数字'))
      }
      if (value.length < 6) {
        callback(new Error('密码最小长度为6位'))
      }
      if (this.form.password !== this.form.repass && this.form.repass !== '') {
        return callback(new Error('密码不一致'))
      }
      callback()
    }
    const validateRePass = (rule, value, callback) => {
      if (!value) {
        return callback(new Error('确认密码不能为空'))
      }
      if (this.form.password !== this.form.repass) {
        return callback(new Error('密码不一致'))
      }
      callback()
    }
    return {
      config: {
        crumb: [
          {
            to: '',
            name: '系统'
          },
          {
            to: '',
            name: '账户管理'
          },
          {
            to: '',
            name: '添加账户'
          }
        ]
      },
      isLoading: false,
      form: {
        username: '',
        password: '',
        realname: '',
        structure_id: null,
        remark: '',
        repass: '',
        groups: []
      },
      orgsOptions: [],
      groupOptions: [],
      selectedGroups: [],
      selectedIds: [],
      rules: {
        username: [{ validator: validateUsername, trigger: 'blur' }],
        password: [{ validator: validatePassword, trigger: 'blur' }],
        repass: [{ validator: validateRePass, trigger: 'blur' }],
        realname: [{ required: true, message: '请输入真实姓名' }],
        structure_id: [{ required: true, message: '请选择用户部门' }]
      }
    }
  },
  methods: {
    selectCheckbox() {
      let temp = false
      _(this.groupOptions).forEach(res => {
        if (this.selectedGroups.toString().indexOf(res.title) > -1) {
          this.selectedIds.push(res.id)
        }
      })
      if (this.selectedIds.length) {
        this.form.groups = _.cloneDeep(this.selectedIds)
        temp = true
      }
      this.selectedIds = []
      return temp
    },
    add(form) {
      if (!this.selectCheckbox()) {
        _g.toastMsg('warning', '请选择用户组')
        return
      }
      this.$refs.form.validate(pass => {
        if (pass) {
          this.isLoading = !this.isLoading
          this.apiPost('admin/users', this.form).then(res => {
            this.handelResponse(
              res,
              data => {
                _g.toastMsg('success', '添加成功')
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
    getAllGroups() {
      this.apiGet('admin/groups').then(res => {
        this.handelResponse(res, data => {
          this.groupOptions = data
        })
      })
    }
  },
  created() {
    this.getAllGroups()
  },
  mixins: [http, fomrMixin]
}
</script>