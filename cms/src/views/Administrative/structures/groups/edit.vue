<template>
  <div>
    <div class="m-l-50 m-t-30 w-900">
      <el-form ref="form" :model="form" :rules="rules" label-width="130px">
        <el-form-item label="用户组名称" prop="title">
          <el-input v-model.trim="form.title" class="h-40 w-200"></el-input>
        </el-form-item>
        <el-form-item label="父级用户组" prop="pid">
          <el-select filterable v-model="form.pid" placeholder="父级用户组" class="w-200">
            <el-option v-for="item in options" :label="item.title" :value="item.id"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="备注">
          <el-input
                  type="textarea"
                  :rows="2"
                  placeholder="备注"
                  v-model="form.remark"
                  class="w-200">
          </el-input>
        </el-form-item>
        <el-form-item label="权限分配">
          <div class="bor-gray h-400 ovf-y-auto bor-ra-5 bg-wh">
            <div v-for="item in nodes">
              <div class="bor-b-ccc bg-gra p-l-10 p-r-10">
                <el-checkbox v-model="item.check" @change="selectProjectRule(item)">{{item.else}}</el-checkbox>
              </div>
              <div v-for="childItem in item.child">
                <div class="p-l-20 bor-b-ccc">
                  <el-checkbox v-model="childItem.check" @change="selectModuleRule(childItem, item, childItem.child)">{{childItem.else}}</el-checkbox>
                </div>
                <div class="p-l-40 bor-b-ccc bg-gra">
                  <el-checkbox v-for="grandChildItem in childItem.child" v-model="grandChildItem.check" @change="selectActionRule(grandChildItem, childItem, item)">{{grandChildItem.else}}</el-checkbox>
                </div>
              </div>
            </div>
          </div>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="edit('form')" :loading="isLoading">提交</el-button>
          <el-button @click="goback()">返回</el-button>
        </el-form-item>
      </el-form>
    </div>
  </div>
</template>
<script>
import http from 'assets/js/http'
import fomrMixin from 'assets/js/form_com'
export default {
  data() {
    return {
      config: {
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
            name: '编辑角色'
          }
        ]
      },
      isLoading: false,
      form: {
        id: null,
        title: '',
        pid: '',
        remark: '',
        rules: '',
        status: null
      },
      options: [{ pid: '0', title: '无' }],
      nodes: [],
      selectedNodes: [],
      rules: {
        title: [{ required: true, message: '请输入用户组名称', trigger: 'blur' }]
      }
    }
  },
  methods: {
    edit(form) {
      console.log('this.nodes', this.nodes)
      this.form.rules = this.selectedNodes.toString()
      console.log(this.selectedNodes)
      this.$refs[form].validate(valid => {
        if (valid) {
          this.isLoading = !this.isLoading
          console.log('提交的数据', this.form)

          this.apiPut('admin/groups/', this.form.id, this.form).then(res => {
            this.handelResponse(
              res,
              data => {
                _g.toastMsg('success', '编辑成功')
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
    getRules() {
      return new Promise((resolve, reject) => {
        this.apiGet('admin/rules?type=tree').then(res => {
          console.log('得到的数据res', res)
          this.handelResponse(res, data => {
            resolve(data)
            console.log('得到的数据1', data)
          })
        })
      })
    },
    getGroups() {
      this.apiGet('admin/groups').then(res => {
        this.handelResponse(res, data => {
          _(data).forEach(res => {
            res.id = res.id.toString()
          })
          this.options = this.options.concat(data)
        })
      })
    },
    async getGroupInfo() {
      this.form.id = this.$route.params.id
      let arr = await this.getRules()
      this.nodes = this.nodes.concat(arr)
      this.apiGet('admin/groups/' + this.form.id).then(res => {
        this.handelResponse(res, data => {
          this.form.title = data.title
          this.form.pid = data.pid ? data.pid.toString() : ''
          this.form.remark = data.remark
          this.form.status = data.status
          let array = data.rules.split(',')
          _(array).forEach(ret => {
            this.selectedNodes.push(parseInt(ret))
            console.log('this.selectedNodes', this.selectedNodes)
          })
          _(this.nodes).forEach(ret => {
            console.log('ret', ret)
            ret.check = false
            if (_(ret.id).includes(this.selectedNodes, parseInt(ret.id))) {
              ret.check = true
            }
            _(ret.child).forEach(ret1 => {
              ret1.check = false
              if (_(this.selectedNodes).includes(parseInt(ret1.id))) {
                ret1.check = true
              }
              _(ret1.child).forEach(ret2 => {
                ret2.check = false
                if (_(this.selectedNodes).includes(parseInt(ret2.id))) {
                  ret2.check = true
                }
              })
            })
          })
        })
      })
    },
    selectProjectRule(item) {
      console.log(item)
      if (!item.check) {
        _(item.child).forEach(res => {
          res.check = false
          let index = _(this.selectedNodes).indexOf(parseInt(res.id))
          this.selectedNodes.splice(index, 1)
          _(res.child).forEach(res1 => {
            res1.check = false
            let index = _(this.selectedNodes).indexOf(parseInt(res1.id))
            this.selectedNodes.splice(index, 1)
          })
        })
      }
      this.selectRule(item)
    },
    selectModuleRule(item, faItem, children) {
      if (!faItem.check) {
        faItem.check = true
        this.selectedNodes.push(parseInt(faItem.id))
      }
      if (item.check) {
        this.selectedNodes.push(parseInt(item.id))
        _(children).forEach(res => {
          res.check = true
          this.selectedNodes.push(parseInt(res.id))
        })
      } else {
        let index = _(this.selectedNodes).indexOf(parseInt(item.id))
        this.selectedNodes.splice(index, 1)
        _(children).forEach(res1 => {
          let temp = _(this.selectedNodes).indexOf(parseInt(res1.id))
          if (temp >= 0) {
            res1.check = false
            this.selectedNodes.splice(temp, 1)
          }
        })
      }
    },
    selectActionRule(item, faItem, grandFaItem) {
      if (!faItem.check) {
        faItem.check = true
        this.selectedNodes.push(parseInt(faItem.id))
      }
      if (!grandFaItem.check) {
        grandFaItem.check = true
        this.selectedNodes.push(parseInt(grandFaItem.id))
      }
      this.selectRule(item)
    },
    selectRule(item) {
      if (item.check) {
        this.selectedNodes.push(parseInt(item.id))
      } else {
        const index = _(this.selectedNodes).indexOf(parseInt(item.id))
        this.selectedNodes.splice(index, 1)
      }
    }
  },
  created() {
    this.$watch('$route', {
      deep: true,
      handler: function() {
        this.getGroupInfo()
      }
    })
    this.getGroupInfo()
    this.getGroups()
  },
  mixins: [http, fomrMixin]
}
</script>