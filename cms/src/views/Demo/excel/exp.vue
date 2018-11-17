<template>
    <code class="exp-code">
        <pre>
            一、需要安装三个依赖 ( 当前模板已经安装 )：

            npm install -S file-saver xlsx

            npm install -D script-loader
        </pre>
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