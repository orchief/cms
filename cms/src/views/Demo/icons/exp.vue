<template>
    <code class="exp-code">
         1. 需要安装 vue-svg-icon <br>
                npm install vue-svg-icon --save-dev <br>
         2. svg图标大小可在相应的页面自定义 如有更多需要可前往 <a href="http://www.iconfont.cn" target="_blank">iconfront</a> 下载或者自定义 svg图标 <br/>
         3. 在 添加菜单 - 图标选项 填入需要的图标的代码 具体代码对应图标在模板页
    </code>
</template>

<style>
.exp-code {
  background: #eef1f6;
  padding: 15px 10px;
  margin-bottom: 20px;
  display: block;
  line-height: 36px;
  font-family: monospace, monospace;
  font-size: 1em;
}
.exp-code a {
  color: #4caf50;
}
</style>

<script>
export default {
  data() {
    return {
      content: '<h1>Some initial content</h1>',
      isLoading: false
    }
  },
  methods: {
    init() {
      console.log('init success')
      _g.closeGlobalLoading()
    }
  },
  created() {
    this.init()
  }
}
</script>