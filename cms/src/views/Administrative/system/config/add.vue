<template>
	<div>
	<div class="m-l-50 m-t-30 w-500">
		<el-form ref="form" :model="form" :rules="rules" label-width="130px">
			<el-form-item label="系统名称" prop="SYSTEM_NAME" >
				<el-input v-model.trim="form.SYSTEM_NAME" class="h-40 w-200"></el-input>
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
			<el-form-item label="登录验证码">
        <el-switch
          v-model="form.IDENTIFYING_CODE"
          active-text="开启"
          inactive-text="关闭">
        </el-switch>
			</el-form-item>
			<el-form-item label="登录有效期(秒)" prop="LOGIN_SESSION_VALID">
				<el-input v-model.number="form.LOGIN_SESSION_VALID" class="h-40 w-200"></el-input>
			</el-form-item>
			<el-form-item>
				<el-button type="primary" @click="add()" :loading="isLoading">提交</el-button>
			</el-form-item>
		</el-form>
		<preview ref="preview" :url="propsImg"></preview>
	</div>
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
      config: {
        crumb: [
          {
            to: '',
            name: '系统'
          },
          {
            to: '',
            name: '系统配置'
          },
          {
            to: '',
            name: '系统参数'
          }
        ]
      },
      isLoading: false,
      fileList: [],
      propsImg: '',
      form: {
        SYSTEM_NAME: '',
        IDENTIFYING_CODE: '0',
        LOGO_TYPE: 1,
        LOGIN_SESSION_VALID: 300,
        SYSTEM_LOGO: ''
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
          this.apiPost('admin/configs', temp).then(res => {
            this.handelResponse(
              res,
              data => {
                _g.toastMsg('success', '提交成功')
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
    this.apiGet('admin/configs').then(res => {
      this.handelResponse(res, data => {
        this.form.SYSTEM_NAME = data.SYSTEM_NAME
        this.form.IDENTIFYING_CODE = Boolean(parseInt(data.IDENTIFYING_CODE))
        this.form.LOGIN_SESSION_VALID = parseInt(data.LOGIN_SESSION_VALID)
        this.imageUrl = ResourceBaseUrl + data.SYSTEM_LOGO
        if (data.SYSTEM_LOGO) {
          let img = window.HOST + data.SYSTEM_LOGO
          this.fileList.push({ name: '图片', url: img })
          this.form.SYSTEM_LOGO = data.SYSTEM_LOGO
        }
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
</style>