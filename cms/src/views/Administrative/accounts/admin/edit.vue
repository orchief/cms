<template>
	<div>
		<!-- <bread-crumb :config="config.crumb"></bread-crumb> -->
		<div class="m-l-50 m-t-30 w-500">
			<el-form ref="form" :model="form" :rules="rules" label-width="130px">
				<el-form-item label="用户名" prop="username">
					<el-input v-model.trim="form.username" class="h-40 w-200" :maxlength=12 :disabled="true"></el-input>
				</el-form-item>
				<el-form-item label="新密码" prop="password">
					<el-input v-model.trim="form.password" class="h-40 w-200" type="password" ></el-input>
				</el-form-item>
        <el-form-item label="确认密码" prop="repass">
					<el-input v-model.trim="form.repass" class="h-40 w-200" type="password" :maxlength=12></el-input>
				</el-form-item>
				<el-form-item label="备注">
					<el-input v-model.trim="form.remark" class="h-40 w-200"></el-input>
				</el-form-item>
				<el-form-item label="用户组">
					<el-checkbox-group v-model="selectedGroups">
						<el-checkbox v-for="item in groupOptions" :label="item.else" class="form-checkbox"></el-checkbox>
					</el-checkbox-group>
				</el-form-item>
				<el-form-item>
					<el-button type="primary" @click="add()" :loading="isLoading">提交</el-button>
					<el-button @click="goback()">返回</el-button>
				</el-form-item>
			</el-form>
		</div>
	</div>
</template>
<style>
.form-checkbox:first-child {
  margin-left: 15px;
}
</style>
<script>
import http from 'assets/js/http'
import fomrMixin from 'assets/js/form_com'
export default {
  data() {
    const validatePassword = (rule, value, callback) => {
      const re = /[^\u0000-\u00FF]+/
      const res = re.test(value)
      console.log(res)
      if (res) {
        callback(new Error('密码只能包含半角字符，字母加数字'))
      }
      if (value.length < 6 && value !== '') {
        callback(new Error('密码最小长度为6位'))
      }
      if (this.form.password !== this.form.repass && this.form.repass !== '') {
        return callback(new Error('密码不一致'))
      }
      callback()
    }
    const validateRePass = (rule, value, callback) => {
      if (
        this.form.password !== this.form.repass &&
        this.form.password !== ''
      ) {
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
            name: '编辑账户'
          }
        ]
      },
      isLoading: false,
      id: null,
      form: {
        username: '',
        realname: '',
        password: '',
        repass: '',
        structure_id: null,
        remark: '',
        groups: []
      },
      repass: '',
      password: '',
      orgsOptions: [],
      groupOptions: [],
      selectedGroups: [],
      selectedIds: [],
      rules: {
        password: [{ validator: validatePassword, trigger: 'blur' }],
        repass: [{ validator: validateRePass, trigger: 'blur' }],
        realname: [{ required: true, message: '请输入真实姓名' }],
        structure_id: [{ required: true, message: '请选择用户所属组织架构' }]
      }
    }
  },
  
  methods: {
    demo(){
      var arr1 =['白色','黑色','红色'];
var arr2 =['2g','4g'];
var table = [],table1=[]
for(var i=0;i<arr1.length;i++){
  for(var j=0;j<arr2.length;j++){
    table.push(arr1[i]+'-'+arr2[j])
  }
}

var arr = [
        [{group:1,attrv:'白色'},{group:1,attrv:'黑色'},{group:1,attrv:'红色'}],
        [{group:2,attrv:'2g'},{group:2,attrv:'4g'}],
    ];

for(var i = 0;i<arr.length;i++){//循环最外面的数组
        for(var j = 0;j<arr[i].length;j++){//循环里面的数组
            
          table.push(arr[i][j])
          
        }
    }

console.log(table);//弹出数组中的每一项
for(var i = 0;i<table.length;i++){//循环最外面的数组
        for(var j = 0;j<table.length;j++){//循环里面的数组
            console.log(table[i],table[j])
//           table.push(arr[i][j])
          
        }
    }
    },
    selectCheckbox() {
      let temp = false
      _(this.groupOptions).forEach(res => {
        if (this.selectedGroups.toString().indexOf(res.else) > -1) {
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
    add() {
      if (!this.selectCheckbox()) {
        _g.toastMsg('warning', '请选择用户组')
        return
      }
      console.log('selectedIds = ', _g.j2s(this.selectedIds))
      this.$refs.form.validate(pass => {
        if (pass) {
          this.isLoading = !this.isLoading
          if (this.password) {
            this.form.password = this.password
          }
          this.apiPut('admin/users/', this.id, this.form).then(res => {
            this.handelResponse(
              res,
              data => {
                _g.toastMsg('success', '修改成功')
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
      return new Promise((resolve, reject) => {
        let data = store.state.userGroups
        if (data && data.length) {
          resolve(data)
        } else {
          this.apiGet('admin/groups').then(res => {
            console.log('groups = ', _g.j2s(res))
            this.handelResponse(res, data => {
              resolve(data)
            })
          })
        }
      })
    },
    async getCompleteData() {
      this.groupOptions = await this.getAllGroups()
      this.apiGet('admin/users/' + this.id).then(res => {
        console.log('res = ', _g.j2s(res))
        this.handelResponse(res, data => {
          this.form.username = data.username
          this.form.realname = data.realname
          this.form.structure_id = data.structure_id
          this.form.remark = data.remark
          _(data.groups).forEach(res1 => {
            _(this.groupOptions).forEach(res2 => {
              if (res1.title === res2.else) {
                this.selectedGroups.push(res1.title)
              }
            })
          })
        })
      })
    }
  },
  created() {
    this.demo()
    this.id = this.$route.params.id
    this.getCompleteData()
    this.$watch('$route', {
      deep: true,
      handler: function() {
        this.id = this.$route.params.id
        this.getCompleteData()
      }
    })
  },
  mixins: [http, fomrMixin]
}
</script>