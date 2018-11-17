<template>
<div>
    <el-upload
  :action="uploadUrl"
  list-type="picture-card"
  :on-preview="handlePictureCardPreview"
  :on-remove="handleRemove"
  :on-success="OnSuccess"
  :file-list="fileList">
  <i class="el-icon-plus"></i>
  </el-upload>
  <el-dialog :visible.sync="dialogVisible" size="tiny">
    <img width="100%" :src="dialogImageUrl" alt="">
  </el-dialog>
</div>
</template>
<script>
import http from 'assets/js/http'
export default {
  data() {
    return {
      dialogImageUrl: '',
      dialogVisible: false,
      uploadUrl: window.ResourceBaseUrl + '/admin/upload',
      fileList: []
    }
  },
  created() {
    _g.closeGlobalLoading()
    const url = 'client/Banners'
    const data = {
      params: {
        ProductId: this.$route.params.id
      }
    }
    this.apiGet(url, data).then(res => {
      this.handelResponse(res, data => {
        console.log('data', data)
        let that = this
        data.list.map(function(i, index) {
          let temp = {}
          temp.name = i.Id
          temp.url = window.ResourceBaseUrl + i.Path
          that.fileList.push(temp)
        })
      })
    })
  },
  methods: {
    handleRemove(file, fileList) {
      console.log(file)
      const url = 'client/Banners'
      this.apiDelete(url + '/' + file.name).then(res => {
        this.handelResponse(res, data => {
          _g.toastMsg('success', '删除成功!')
        })
      })
    },
    handlePictureCardPreview(file) {
      console.log('file.url', file.url)
      this.dialogImageUrl = file.url
      this.dialogVisible = true
    },
    OnSuccess(response, file, fileList) {
      console.log('file', file)
      file.url = window.ResourceBaseUrl + response.data
      const url = 'client/Banners'
      const data = {
        Path: response.data
      }
      this.apiPost(url, data).then(res => {
        this.handelResponse(res, data => {
          file.name = data
          _g.toastMsg('success', '新增成功!')
        })
      })
    }
  },
  mixins: [http]
}
</script>