<template>
    <div class="demo-svg-icon">
        <div :title="icon" v-for="icon in icons">
            <icon :class="icon + '-icon'" :name="icon" ></icon>
            <p>{{ icon }}</p>
        </div>
    </div>
</template>

<style scoped="scoped">
/* svg图标大小可在相应的页面自定义 如有更多需要可前往iconfront 下载或者自定义 svg图标 */
.demo-svg-icon > div {
  float: left;
  margin-left: 40px;
  height: 137px;
  text-align: center;
  width: 120px;
  font-size: 40px;
  color: #666;
  cursor: pointer;
}
.demo-svg-icon > div > p {
  font-size: 16px;
}
</style>

<script>
export default {
  data() {
    return {
      icons: null
    }
  },
  methods: {
    init() {
      this.icons = [
        'bug',
        'chart',
        'zip',
        'wechat',
        'user',
        'trendChart1',
        'trendChart2',
        'trendChart3',
        'theme',
        'table',
        'tab',
        'star',
        'qq',
        'people',
        'password',
        'icon',
        'form',
        'eye',
        'lock',
        'excel',
        'example',
        'email',
        'drag',
        'component',
        'clipboard',
        'chart',
        '404',
        'upload',
        'medical',
        'check',
        'items',
        'download',
        'recover'
      ]
    }
  },
  created() {
    this.init()
    _g.closeGlobalLoading()
  }
}
</script>
