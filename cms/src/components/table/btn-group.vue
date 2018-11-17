<template>
	<div>
    <template v-for="item in config">
		  <el-button :loading="data[item.loading]" :size="item.size" @click="btnGroup(item)">{{item.title}}</el-button>
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
        array.push(res.id)
      })
      return array
    },
    btnGroup(actionParam) {
      switch (actionParam.type) {
        case 'status': // 禁用
          this.changeAttrInBtnGroup(actionParam)
          break
        case 'del': // 启用
          this.deleteDatasInBtnGroup()
          break
      }
    },
    changeAttrInBtnGroup(actionParam) {
      let cate = actionParam.param
      let word = actionParam.word
      if (!this.selectedData.length) {
        _g.toastMsg('warning', '请勾选数据')
        return
      }
     
      if (cate === 1) {
        this.enableLoading = !this.enableLoading
      } else {
        this.disableLoading = !this.disableLoading
      }
      let url = this.baseApi + '/enables'
      let data = {
        ids: this.getSelectedIds(),
        status: cate
      }
      this.apiPost(url, data).then(res => {
        this.handelResponse(
          res,
          data => {
            _g.toastMsg('success', word)
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