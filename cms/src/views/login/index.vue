<template>
  <div class="backgroundImg-login">
    <img src="../../assets/images/logo.png" alt="" class="login-logo">
    <span class='meg-login'>欢迎来到{{systemName}}，请登录!</span>
    <el-form :model="form" :rules="rules2" ref="form" label-position="left" label-width="0px" class="demo-ruleForm card-box loginform">
      <h3 class="title">{{systemName}}</h3>
      <el-form-item prop="username">
        <el-input type="text" v-model="form.username" auto-complete="off" placeholder="账号"></el-input>
      </el-form-item>
      <el-form-item prop="password">
        <el-input type="password" v-model="form.password" auto-complete="off" placeholder="密码"></el-input>
      </el-form-item>
      <el-form-item v-show="requireVerify" prop="verifyCode">
        <el-input type="text" v-model="form.verifyCode" auto-complete="off" placeholder="验证码" class="w-150"></el-input>
        <img :src="verifyUrl" @click="refreshVerify()" class="verify-pos" />
      </el-form-item>
      <el-checkbox v-model="checked" style="margin:0px 0px 35px 0px;">记住密码</el-checkbox>
      <el-form-item style="width:100%;">
        <el-button type="primary" style="width:100%;" v-loading="loading" @click.native.prevent="handleSubmit2('form')">登录</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import http from 'assets/js/http'

export default {
  data() {
    return {
      title: '',
      systemName: '',
      loading: false,
      form: {
        username: '',
        password: '',
        verifyCode: ''
      },
      requireVerify: false,
      verifyUrl: '',
      verifyImg: ResourceBaseUrl + 'verify',
      rules2: {
        username: [{ required: true, message: '请输入账号', trigger: 'blur' }],
        password: [{ required: true, message: '请输入密码', trigger: 'blur' }],
        verifyCode: [{ required: false, message: '请输入验证码', trigger: 'blur' }]
      },
      checked: false
    }
  },
  methods: {
    refreshVerify() {
      this.verifyUrl = ''
      setTimeout(() => {
        this.verifyUrl = this.verifyImg + '?v=' + moment().unix()
      }, 300)
    },
    handleSubmit2(form) {
      if (this.loading) return
      this.$refs.form.validate(valid => {
        if (valid) {
          this.loading = !this.loading
          const data = {}
          if (this.requireVerify) {
            data.username = this.form.username
            data.password = this.form.password
            data.verifyCode = this.form.verifyCode
          } else {
            data.username = this.form.username
            data.password = this.form.password
          }
          if (this.checked) {
            data.isRemember = 1
          } else {
            data.isRemember = 0
          }
          this.apiPost('admin/login', data).then(res => {
            this.handelResponse(
              res,
              data => {
                this.refreshVerify()
                  if (this.checked) {
                    Cookies.set('rememberPwd', true, { expires: 1 })
                  }
                  //硬盘存储
                  this.resetCommonData(data)
                  // _g.toastMsg('success', '登录成功')
              },
              () => {
                this.loading = !this.loading
              }
            )
          })
        } else {
          return false
        }
      })
    },
    checkIsRememberPwd() {
      if (Cookies.get('rememberPwd')) {
        const data = {
          rememberKey: window.sessionStorage.getItem('rememberKey')
        }
        this.apiPost('admin/base/relogin', data).then(res => {
          this.handelResponse(res, data => {
            this.resetCommonData(data)
          })
        })
      }
    }
  },
  created() {
    this.checkIsRememberPwd()
    this.apiGet('admin/configs').then(res => {
      this.handelResponse(res, data => {
        document.title = data.SYSTEM_NAME
        this.systemName = data.SYSTEM_NAME
        if (parseInt(data.idENTIFYING_CODE)) {
          this.requireVerify = true
          this.rules2.verifyCode[0].required = true
        }
      })
    })
    this.verifyUrl = this.verifyImg
  },
  mounted() {
    
    addEventListener('keyup', e => {
      if (e.keyCode === 13) {
        this.handleSubmit2('form')
      }
    })
  },
  mixins: [http]
}
</script>

<style scoped>
.verify-pos {
  position: absolute;
  right: 100px;
  top: 0px;
}

.backgroundImg-login{
  background-color: #ffffff;
  background-image: url(../../assets/images/backgroud.png);
  background-repeat:no-repeat; 
  background-position:0 100px;
  background-size:100% 500px;
}

.login-logo{
  height: 100px;
  margin-left: 160px;
}

.meg-login{
  width: 372px;
  margin-right: 117px;
  float: right;
  margin-top: 75px;
}

.card-box {
  padding: 20px;
  /*box-shadow: 0 0px 8px 0 rgba(0, 0, 0, 0.06), 0 1px 0px 0 rgba(0, 0, 0, 0.02);*/
  -webkit-border-radius: 5px;
  border-radius: 5px;
  -moz-border-radius: 5px;
  background-clip: padding-box;
  margin-bottom: 20px;
  background-color: #f9fafc;
  margin: 120px auto;
  width: 400px;
  border: 2px solid #8492a6;
}

.title {
  margin: 0px auto 40px auto;
  text-align: center;
  color: #505458;
}

.loginform {
  width: 350px;
  padding: 35px 35px 15px 35px;
  margin-right: 120px;
}


</style>