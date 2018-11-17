<template>
  <div class="scroll-container" ref="scrollContainer" @mousewheel="handleScroll">
    <div class="scroll-wrapper" ref="scrollWrapper" :style="{right: right + 'px'}">
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {
  name: 'scrollPane',
  data() {
    return {
      right: 0
    }
  },
  methods: {
    handleScroll(e) {
      e.preventDefault()
      const $container = this.$refs.scrollContainer
      const $containerWidth = $container.offsetWidth
      const $wrapper = this.$refs.scrollWrapper
      
      const $wrapperWidth = $wrapper.offsetWidth
      if (e.wheelDelta > 0) {
        this.right = Math.min(0, this.right + e.wheelDelta)
      } else {
        if ($containerWidth - 100 < $wrapperWidth) {
          if (this.right < -($wrapperWidth - $containerWidth + 100)) {
            this.right = this.right
          } else {
            this.right = Math.max(this.right + e.wheelDelta, $containerWidth - $wrapperWidth - 100)
          }
        } else {
          console.log(this)
          this.right = 0
        }
      }
    }
  }
}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.scroll-container {
  white-space: nowrap;
  position: relative;
  overflow: hidden;
  background: none;
  border-bottom: none;
  box-shadow:none;
  .scroll-wrapper {
    position: absolute;
  }
}
</style>
