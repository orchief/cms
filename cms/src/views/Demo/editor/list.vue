<template>
  <div>富文本编辑器</div>
</template>

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