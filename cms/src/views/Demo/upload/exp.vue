<template>
    <code class="exp-code">
        更多上传ui 见 <a href="http://element.eleme.io/#/zh-CN/component/upload" target="_blank">elementUi官网</a>
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