<template>
  <div class="lcontent">
  	<div class="lcontent">
		<div class="content">
			<img style="width: 7rem;position: relative;right: -20rem;" src="../../assets/images/1.png"/>
			<img style="width: 22rem;position: relative;top: 8rem;left: -4rem;" src="../../assets/images/6.png"/>
			<div class="inputk">
				 <i class="icon-search"></i>
				<input style="padding-left:4rem;border-top-left-radius: 1rem;border-top-right-radius: 1rem;border-bottom: 1px solid #CCCCCC;" type="text" name="" id="name" value="" ref="name" placeholder="请 输 入 登 录 账 号 " /><br>
				 <i class="icon-search2"></i>
				<input style="padding-left:4rem;border-bottom-left-radius: 1rem;border-bottom-right-radius: 1rem;" type="password" name="" id="pass" ref="pass" value="" placeholder="输 入 您 的 密 码 " />
			</div>
			<div class="chec">
				<input type="checkbox" name="" id="" value="" /> 忘记密码
			</div>
			<div style="width: 100%;">
				
				<img class="loginclick" src="../../assets/images/2.png"/>
				<p class="spanlogin" @click="handleSubmit2">登 录</p>
			</div>
		</div>
		</div>
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
    handleSubmit3() {
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
     handleSubmit2() {
      if (this.loading) return
          this.loading = !this.loading
          const data = {}
         
            data.username = this.$refs.name.value
            data.password = this.$refs.pass.value
         
          this.apiPost('http://api.shop.pstech360.com/admin/login', data).then(res => {
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
       
      
    },
    clickspan(){
			console.log("123")
			const data = {}
			data.username = this.$refs.name.value
      data.password = this.$refs.pass.value
      console.log(data)
			this.apiPost('admin/login', data).then(res => {
            this.handelResponse(
              res,
              data => {

//              this.refreshVerify()
//                if (this.checked) {
//                  Cookies.set('rememberPwd', true, { expires: 1 })
//                }
                  //硬盘存储
                  this.resetCommonData(data)
                     _g.toastMsg('success', '登录成功')
              },
              () => {
                this.loading = !this.loading
              }
            )
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
    
//  var pass = $("#pass").val()
//  var name = $("#name").val()
    
//  $.ajax({
//  	type:"post",
//  	url:"admin/login",
//  	async:true,
//  	data:{
//  		"username" : name,
//  		"password" : pass
//  	},
//  	success:function(res_str){
//  		console.log(res_str);
//  		if (res_str.code == 200) {
//  			
//  		}
//  	}
//  });
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
			html{
				background: url(../../assets/images/3.png) no-repeat;
				background-size: 100% 100%;
				width: 100%;
				height: 100%;
			}
			
			.content{
				position: absolute;
				right: 7rem;
				top: 5rem;
				width: 30rem;
				height: 40rem;
				background-color: rgba(55,96,78,0.9);
				border-radius: 1rem;
			}
			
			.inputk{
				position: relative;
    			top: 10rem;
    			left: 2rem;
			}
			
			.inputk input{
				width: 22rem;
    			border: 0;
    			height: 3.5rem;
    			font-size: 1.2rem;
			}
			
			.icon-search{
                background: url(statics/images/5.png) no-repeat;
			    width: 2.5rem;
			    height: 2.5rem;
			    position: absolute;
			    top: 1rem;
			    left: 1rem;
            }
            .icon-search2{
                background: url(statics/images/4.png) no-repeat;
    			width: 2.5rem;
   				height: 2.5rem;
    			position: absolute;
    			top: 4.3rem;
    			left: 1.3rem;
            }
            
            .chec{
            	position: relative;
    			top: 11rem;
   		 		left: 2rem;
    			color: #FFFFFF;
     	      }
   
			.loginclick{
				width: 87%;
				position: relative;
				top: 13rem;
				left: 2rem;
				opacity: 1;
			}
			.spanlogin{
				position: relative;
    top: 13rem;
    left: -13rem;
    display: inline-block;
    color: #FFFFFF;
    font-size: 1.2rem;
			}
			
			.lcontent{
				width: 100%;
				height: 100%;
				 background: url(../../assets/images/3.png) no-repeat;
				 background-size: 100% 100%;
			}

</style>