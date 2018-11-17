<template>
	<div>
    <el-row>
      <el-col :span="24" class='config--box-border'>
    <el-row>
      <div >
      <center style="height:60px;line-height:60px">微信配置</center>
      </div>
    </el-row> 
    <el-row>
      <center>
		<el-form ref="form" :model="form" :rules="rules" label-width="160px">
			<el-form-item label="app_id  " prop="app_id" >
				<el-input v-model.trim="form.wechat.app_id" class="h-40 w-500"></el-input>
			</el-form-item>

      <el-form-item label="mch_id  " prop="mch_id" >
				<el-input v-model.trim="form.wechat.mch_id" class="h-40 w-500"></el-input>
			</el-form-item>

      <el-form-item label="key  " prop="key" >
				<el-input v-model.trim="form.wechat.key" class="h-40 w-500"></el-input>
			</el-form-item>
      
      <el-form-item label="secret  " prop="secret" >
				<el-input v-model.trim="form.wechat.secret" class="h-40 w-500"></el-input>
			</el-form-item>
      
			<!-- <el-form-item label="LOGO">
				<el-upload
						class="avatar-uploader"
						:action="uploadUrl"
						:show-file-list="false"
						:on-success="handleAvatarSuccess"
						:before-upload="beforeAvatarUpload">
					<img v-if="imageUrl" :src="imageUrl" class="avatar">
					<i v-else class="el-icon-plus avatar-uploader-icon"></i>
				</el-upload>
			</el-form-item> -->
      <!--<el-form-item label="LOGO类型">-->
        <!--<el-radio-group v-model="form.LOGO_TYPE">-->
          <!--<el-radio label="1">图片</el-radio>-->
          <!--<el-radio label="2">文字</el-radio>-->
        <!--</el-radio-group>-->
      <!--</el-form-item>-->
			<!-- <el-form-item label="登录验证码">
        <el-switch
          v-model="form.IDENTIFYING_CODE"
          active-text="开启"
          inactive-text="关闭">
        </el-switch>
			</el-form-item>
			<el-form-item label="登录有效期(秒)" prop="LOGIN_SESSION_VALID">
				<el-input v-model.number="form.LOGIN_SESSION_VALID" class="h-40 w-200"></el-input>
			</el-form-item> -->
			<el-form-item>
				<el-button type="primary" @click="add()" :loading="isLoading1">提交</el-button>
			</el-form-item>
		</el-form>
    </center>
    </el-row>
      </el-col>
    </el-row>
    <el-row>

    <el-col :span="24" class='config--box-border'>
    <el-row>
      <div >
      <center style="height:60px;line-height:60px">支付宝支付配置</center>
      </div>
    </el-row> 
    <el-row>
      <center>
		<el-form ref="form" :model="form" :rules="rules" label-width="160px">
			<el-form-item label="appid  " prop="app_id" >
				<el-input v-model.trim="form.alipay.app_id" class="h-40 w-500"></el-input>
			</el-form-item>

      <el-form-item label="伙伴id(商户id)" prop="partner" >
				<el-input v-model.trim="form.alipay.partner" class="h-40 w-500"></el-input>
			</el-form-item>

      <el-form-item label="支付宝公钥" prop="ali_public_key" >
				<el-input v-model.trim="form.alipay.ali_public_key" class="h-40 w-500"></el-input>
			</el-form-item>
      
      <el-form-item label="私钥" prop="rsa_private_key" >
				<el-input v-model.trim="form.alipay.rsa_private_key" class="h-40 w-500"></el-input>
			</el-form-item>

      <el-form-item label="信号类型" prop="sign_type" >
				<el-input v-model.trim="form.alipay.sign_type" class="h-40 w-500"></el-input>
			</el-form-item>

      <el-form-item label="回调地址" prop="notify_url" >
				<el-input v-model.trim="form.alipay.notify_url" class="h-40 w-500"></el-input>
			</el-form-item>
	
			<el-form-item>
				<el-button type="primary" @click="add()" :loading="isLoading2">提交</el-button>
			</el-form-item>
		</el-form>
    </center>
    </el-row>
      </el-col>


            <el-col :span="24" class='config--box-border'>
    <el-row>
      <div >
      <center style="height:60px;line-height:60px">短信配置</center>
      </div>
    </el-row> 
    <el-row>
      <center>
		<el-form ref="form" :model="form" :rules="rules" label-width="160px">
			<el-form-item label="网关地址  " prop="sendUrl" >
				<el-input v-model.trim="form.smsConf.sendUrl" class="h-40 w-500"></el-input>
			</el-form-item>

      <el-form-item label="短信秘钥" prop="key" >
				<el-input v-model.trim="form.smsConf.key" class="h-40 w-500"></el-input>
			</el-form-item>

      <el-form-item label="短信模板id" prop="tpl_id" >
				<el-input v-model.trim="form.smsConf.tpl_id" class="h-40 w-500"></el-input>
			</el-form-item>
      
      <el-form-item label="短信签名" prop="company" >
				<el-input v-model.trim="form.smsConf.company" class="h-40 w-500"></el-input>
			</el-form-item>

      <el-form-item label="短信长度" prop="length" >
				<el-input v-model.trim="form.smsConf.length" class="h-40 w-500"></el-input>
			</el-form-item>
	
			<el-form-item>
				<el-button type="primary" @click="add()" :loading="isLoading2">提交</el-button>
			</el-form-item>
		</el-form>
    </center>
    </el-row>
      </el-col>

    </el-row>

    <!-- 下一行 -->
        <el-row>
      <el-col :span="24" class='config--box-border'>
    <el-row>
      <div >
      <center style="height:60px;line-height:60px">物流配置</center>
      </div>
    </el-row> 
    <el-row>
      <center>
		<el-form ref="form" :model="form" :rules="rules" label-width="160px">
			<el-form-item label="接口网关  " prop="sendUrl" >
				<el-input v-model.trim="form.express.sendUrl" class="h-40 w-500"></el-input>
			</el-form-item>

      <el-form-item label="秘钥  " prop="key" >
				<el-input v-model.trim="form.express.key" class="h-40 w-500"></el-input>
			</el-form-item>

      <el-form-item label="customer" prop="customer" >
				<el-input v-model.trim="form.express.customer" class="h-40 w-500"></el-input>
			</el-form-item>
      
			<el-form-item>
				<el-button type="primary" @click="add()" :loading="isLoading3">提交</el-button>
			</el-form-item>
		</el-form>
    </center>
    </el-row>
      </el-col>

    </el-row>

    <el-row>
      
        <el-col :span="24" class='config--box-border'>
    <el-row>
      <div >
      <center style="height:60px;line-height:60px">接口鉴权配置</center>
      </div>
    </el-row> 
    <el-row>
      <center>
		<el-form ref="form" :model="form" :rules="rules" label-width="160px">
			<el-form-item label="私钥" prop="key" >
				<el-input v-model.trim="form.jwt.key" class="h-40 w-500"></el-input>
			</el-form-item>

      <el-form-item label="用户登录有效期" prop="expire" >
				<el-input v-model.trim="form.jwt.expire" class="h-40 w-500"></el-input>
			</el-form-item>

			<el-form-item>
				<el-button type="primary" @click="add()" :loading="isLoading4">提交</el-button>
			</el-form-item>
		</el-form>
    </center>
    </el-row>
      </el-col>
    </el-row>

	</div>
</template>
<script>
import http from 'assets/js/http'
import preview from './preview.vue'
export default {
  data() {
    let check_LOGIN_SESSION_VALID = (rule, value, callback) => {
      if (!value) {
        return callback(new Error('登录会话有效期不能为空'))
      }
      if (!Number.isInteger(value)) {
        callback(new Error('请输入数字值'))
      } else {
        if (value < 300) {
          callback(new Error('必须大于300(5分钟)'))
        } else {
          callback()
        }
      }
    }
    return {
      isLoading1: false,
      isLoading2: false,
      isLoading3: false,
      isLoading4: false,
      fileList: [],
      propsImg: '',
      form: {
        wechat: {
          app_id: '',
          mch_id: '',
          key: '',
          secret: ''
        },
        alipay: {
          app_id: '',
          partner: '',
          ali_public_key: '',
          rsa_private_key: '',
          sign_type: '',
          notify_url: ''
        },
        smsConf: {
          sendUrl: '',
          key: '',
          tpl_id: '',
          company: '',
          length: 0
        },
        express: {
          sendUrl: '',
          key: '',
          customer: ''
        },
        jwt: {
          key: '',
          expire: 0
        }
      },
      uploadUrl: '',
      imageUrl: '',
      rules: {
        SYSTEM_NAME: [
          { required: true, message: '请输入系统名称', trigger: 'blur' },
          { min: 3, max: 15, message: '长度在 3 到 15 个字符', trigger: 'blur' }
        ],
        LOGIN_SESSION_VALID: [
          { validator: check_LOGIN_SESSION_VALID, trigger: 'blur' }
        ]
      }
    }
  },
  methods: {
    add() {
      this.$refs.form.validate(pass => {
        if (pass) {
          this.isLoading = !this.isLoading
          let temp = {}
          // 系列化对象
          let str = JSON.stringify(this.form)
          temp = JSON.parse(str) // 还原
          if (temp.IDENTIFYING_CODE) {
            temp.IDENTIFYING_CODE = 1
          } else {
            temp.IDENTIFYING_CODE = 0
          }
          this.apiPost('admin/appConfigs', temp).then(res => {
            this.handelResponse(
              res,
              data => {
                _g.toastMsg('success', '修改成功!')
                this.isLoading = !this.isLoading
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
      this.imageUrl = ResourceBaseUrl + res.data
      this.form.SYSTEM_LOGO = res.data
      _g.closeGlobalLoading()
    },
    beforeAvatarUpload(file) {
      _g.openGlobalLoading()
      const isJPG = file.type === 'image/jpeg'
      const isLt2M = file.size / 1024 / 1024 < 2

      if (!isJPG) {
        this.$message.error('上传头像图片只能是 JPG 格式!')
        _g.closeGlobalLoading()
      }
      if (!isLt2M) {
        this.$message.error('上传头像图片大小不能超过 2MB!')
        _g.closeGlobalLoading()
      }
      return isJPG && isLt2M
    }
  },
  created() {
    this.uploadUrl = window.ResourceBaseUrl + '/admin/upload'
    this.apiGet('admin/appConfigs').then(res => {
      this.handelResponse(res, data => {
        // wechatpay
        this.form.wechat.app_id = data.wechat.app_id
        this.form.wechat.mch_id = data.wechat.mch_id
        this.form.wechat.key = data.wechat.key
        this.form.wechat.secret = data.wechat.secret

        // alipay
        this.form.alipay.ali_public_key = data.alipay.ali_public_key
        this.form.alipay.rsa_private_key = data.alipay.rsa_private_key
        this.form.alipay.app_id = data.alipay.app_id
        this.form.alipay.partner = data.alipay.partner
        this.form.alipay.notify_url = data.alipay.notify_url
        this.form.alipay.sign_type = data.alipay.sign_type

        // 短信配置
        this.form.smsConf.sendUrl = data.smsConf.sendUrl
        this.form.smsConf.key = data.smsConf.key
        this.form.smsConf.tpl_id = data.smsConf.tpl_id
        this.form.smsConf.company = data.smsConf.company
        this.form.smsConf.length = data.smsConf.length

        // 物流
        this.form.express.sendUrl = data.express.sendUrl
        this.form.express.key = data.express.key
        this.form.express.customer = data.express.customer

        // 接口鉴权
        this.form.jwt.expire = data.jwt.expire
        this.form.jwt.key = data.jwt.key
      })
    })
  },
  components: {
    preview
  },
  mixins: [http]
}
</script>

<style>
.avatar-uploader .el-upload {
  border: 1px dashed #d9d9d9;
  border-radius: 6px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}
.avatar-uploader .el-upload:hover {
  border-color: #409eff;
}
.avatar-uploader-icon {
  font-size: 28px;
  color: #8c939d;
  width: 178px;
  height: 178px;
  line-height: 178px;
  text-align: center;
}
.avatar {
  width: 178px;
  height: 178px;
  display: block;
}
.config--box-border{
  border: 1px solid #ccc;
  border-radius: 10px;
}
</style>