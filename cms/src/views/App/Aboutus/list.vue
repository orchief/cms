<template>
<div>
  <el-form ref="form" :model="form" label-width="130px">
    <el-form-item label="移动端">
        <quill-editor v-model="form.App"
              ref="myQuillEditor"
              >
        </quill-editor>
      </el-form-item>

      <el-form-item label="电脑端">
        <quill-editor v-model="form.Pc"
              ref="myQuillEditor"
              >
        </quill-editor>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="commit">确 定</el-button>
      </el-form-item>
  </el-form>  
</div>
</template>

<script>
import http from 'assets/js/http.js'
// require styles
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'
import { quillEditor } from 'vue-quill-editor'

export default {
  components: {
    quillEditor
  },
  data() {
    return {
      form: {
        App: null,
        Pc: null
      }
    }
  },
  created() {
    this.init()
  },
  methods: {
    init() {
      // 基本数据获取
      this.tableData()
    },
    tableData() {
      const url = 'client/aboutus'
      this.apiGet(url).then(res => {
        this.handelResponse(res, data => {
          console.log(data)
          this.form = data.list[0]
          _g.closeGlobalLoading()
        })
      })
    },
    commit() {
      const url = 'client/aboutus'
      const data = this.form
      this.apiPut(url + '/', 1, data).then(res => {
        this.handelResponse(res, data => {
          _g.toastMsg('success', data)
        })
      })
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
