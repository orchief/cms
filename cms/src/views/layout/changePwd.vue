<template>
	<el-dialog ref="dialog" custom-class="w-400 h-350" title="修改密码" :visible.sync="dialogVisible">
		<div class="ovf-auto">
			<el-form ref="form" :model="form" :rules="rules" label-width="80px">
				<el-form-item label="旧密码" prop="old_pwd">
					<el-input v-model.trim="form.old_pwd" type="password"></el-input>
				</el-form-item>
				<el-form-item label="新密码" prop="new_pwd">
					<el-input v-model.trim="form.new_pwd" type="password"></el-input>
				</el-form-item>
        <el-form-item label="确认密码" prop="re_new_pwd">
					<el-input v-model.trim="form.re_new_pwd" type="password"></el-input>
				</el-form-item>
			</el-form>
		</div>
		<div class="p-t-20">
			<el-button @click="dialogVisible = false">取 消</el-button>
    	<el-button type="primary" @click="submit()" :disabled="disable">提 交</el-button>
		</div>
	</el-dialog>
</template>
<style>

</style>
<script>
import http from 'assets/js/http'

export default {
  data() {
    const validateOldPass = (rule, value, callback) => {
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
      if (this.form.old_pwd === this.form.new_pwd) {
        return callback(new Error('新旧密码不能一致'))
      }
      callback()
    }
    const validateNewPass = (rule, value, callback) => {
      if (!value) {
        return callback(new Error('新密码不能为空'))
      }
      const re = /[^\u0000-\u00FF]+/
      const res = re.test(value)
      console.log(res)
      if (res) {
        callback(new Error('新密码只能包含半角字符，字母加数字'))
      }
      if (value.length < 6) {
        callback(new Error('新密码最小长度为6位'))
      }
      if (this.form.old_pwd === this.form.new_pwd) {
        return callback(new Error('新旧密码不能一致'))
      }
      callback()
    }
    const validateReNewPass = (rule, value, callback) => {
      if (!value) {
        return callback(new Error('确认密码不能为空'))
      }
      if (this.form.new_pwd !== this.form.re_new_pwd) {
        return callback(new Error('密码不一致'))
      }
      callback()
    }
    return {
      dialogVisible: false,
      disable: false,
      form: {
        old_pwd: '',
        new_pwd: '',
        re_new_pwd: ''
      },
      rules: {
        old_pwd: [
          { validator: validateOldPass, trigger: 'blur' },
          { min: 6, max: 12, message: '长度在 6 到 12 个字符', trigger: 'blur' }
        ],
        new_pwd: [
          { validator: validateNewPass, trigger: 'blur' },
          { min: 6, max: 12, message: '长度在 6 到 12 个字符', trigger: 'blur' }
        ],
        re_new_pwd: [
          { validator: validateReNewPass, trigger: 'blur' },
          { min: 6, max: 12, message: '长度在 6 到 12 个字符', trigger: 'blur' }
        ]
      }
    }
  },
  methods: {
    open() {
      this.dialogVisible = true
      this.$refs.dialog.open()
    },
    close() {
      this.dialogVisible = false
      this.$refs.dialog.close()
    },
    submit() {
      this.$refs.form.validate(pass => {
        if (pass) {
          this.disable = !this.disable
          this.apiPost('/admin/modifypass', this.form).then(res => {
            this.handelResponse(
              res,
              data => {
                _g.toastMsg('success', '修改成功')
                router.replace('/cms/login')
              },
              () => {
                this.disable = !this.disable
              }
            )
          })
        }
      })
    }
  },
  created() {
    this.form.auth_key = window.sessionStorage.getItem('authKey')
  },
  mixins: [http]
}
</script>