<template>
    <code class="exp-code">
        这是富文本编辑器的介绍与使用说明...
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