<template>
	<div>
    <template v-for="item in config">
		  <el-button :loading="data[item.loading]" :size="item.size" @click="btnGroup(item.param)">{{item.title}}</el-button>
    </template>
	</div>
</template>

<script>
import http from '../../assets/js/http'

export default {
  props: ['selectedData', 'baseApi', 'config'],
  data() {
    return {
      data: {
        enableLoading: false,
        disableLoading: false,
        deleteLoading: false
      }
    }
  },
  methods: {
    getSelectedIds() {
      let array = []
      _(this.selectedData).forEach(res => {
        array.push(res.Id)
      })
      return array
    },
    btnGroup(actionParam) {
      switch (actionParam) {
        case 0: // 禁用
          this.changeAttrInBtnGroup(actionParam)
          break
        case 1: // 启用
          this.changeAttrInBtnGroup(actionParam)
          break
        case 2: // 删除
          this.deleteDatasInBtnGroup()
          break
      }
    },
    changeAttrInBtnGroup(cate) {
      if (!this.selectedData.length) {
        _g.toastMsg('warning', '请勾选数据')
        return
      }
      let word = ''
      if (cate === 1) {
        word = '启用'
        this.enableLoading = !this.enableLoading
      } else {
        this.disableLoading = !this.disableLoading
        word = '禁用'
      }
      let url = this.baseApi + '/enables'
      console.log(url)
      let data = {
        ids: this.getSelectedIds(),
        status: cate
      }
      this.apiPost(url, data).then(res => {
        this.handelResponse(
          res,
          data => {
            _g.toastMsg('success', word + '成功')
            setTimeout(() => {
              _g.shallowRefresh(this.$route.name)
            }, 1500)
          },
          () => {
            if (cate === 1) {
              this.enableLoading = !this.enableLoading
            } else {
              this.disableLoading = !this.disableLoading
            }
          }
        )
      })
    },
    deleteDatasInBtnGroup() {
      if (!this.selectedData.length) {
        _g.toastMsg('warning', '请勾选数据')
        return
      }
      this.deleteLoading = !this.deleteLoading
      let url = this.baseApi + '/deletes'
      let data = {
        ids: this.getSelectedIds()
      }
      this.apiPost(url, data).then(res => {
        this.handelResponse(
          res,
          data => {
            _g.toastMsg('success', res.data)
            setTimeout(() => {
              _g.shallowRefresh(this.$route.name)
            }, 1500)
          },
          () => {
            this.deleteLoading = !this.deleteLoading
          }
        )
      })
    }
  },
  computed: {
    enableShow() {
      return _g.getHasRule(this.type + '-enables')
    },
    deletesShow() {
      return _g.getHasRule(this.type + '-deletes')
    }
  },
  mixins: [http]
}
</script>