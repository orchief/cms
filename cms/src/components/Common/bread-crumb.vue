<template>
    <!-- 下一步实现可修正的自动面包屑导航 () -->
    <div class="m-b-10  l-h-15 breadcrumb">
        <div class="fl betterline">
          <bread-path :levelList="levelList"></bread-path>
        </div>
        
        <!-- <scroll-pane class='tags-view-container'>
          <router-link class="tags-view-item" :class="isActive(tag)?'active':''" v-for="tag in Array.from(visitedViews)" :to="tag.path" :key="tag.path">
             {{tag.name}}
          <span class='el-icon-close' @click='closeViewTags(tag,$event)'></span>
          </router-link>
        </scroll-pane> -->
    </div>
</template>

<script>
import ScrollPane from 'components/ScrollPane'
import breadPath from './bread-path.vue'
export default {
  components: { ScrollPane, breadPath },
  data() {
    return {
      tempRoute: '',
      levelList: ''
    }
  },
  computed: {
    visitedViews() {
      return this.$store.state.app.visitedViews
    }
  },
  mounted() {
    this.$watch('$route', {
      deep: true,
      handler: function() {
        if (this.$route.name !== 'refresh') {
          this.levelList = this.$route.matched.filter(item => item.name)
        }
      }
    })
    this.addViewTags()
  },
  methods: {
    closeViewTags(view, $event) {
      this.$store.dispatch('delVisitedViews', view).then(views => {
        if (this.isActive(view)) {
          const latestView = views.slice(-1)[0]
          if (latestView) {
            this.$router.push(latestView.path)
          } else {
            this.$router.push('/')
          }
        }
      })
      $event.preventDefault()
    },
    generateRoute() {
      if (this.$route.name === 'refresh') {
        return false
      } else {
        this.tempRoute = this.$route
      }
      if (this.$route.name) {
        return this.$route
      }
      return false
    },
    addViewTags() {
      const route = this.generateRoute()
      if (!route) {
        return false
      }
      this.$store.dispatch('addVisitedViews', route)
    },
    isActive(route) {
      return (
        route.path === this.tempRoute.path || route.name === this.tempRoute.name
      )
    }
  },
  watch: {
    $route() {
      this.addViewTags()
    }
  },
  created(){
    this.levelList = this.$route.matched.filter(item => item.name)
  }
}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.close-all-tag-con {
  position: absolute;
  right: 0;
  top: 0;
  box-sizing: border-box;
  padding-top: 8px;
  text-align: center;
  width: 110px;
  height: 100%;
  background: white;
  box-shadow: -3px 0 15px 3px rgba(0, 0, 0, 0.1);
  z-index: 10;
}
.el-breadcrumb {
  margin-right: 20px;
}
.betterline {
  padding-left:10px;
  background: url(../../assets/images/location.png) no-repeat left 4px;
}
.tags-view-container {
  // background: #fff;
  height: 34px;
  // border-bottom: 1px solid #d8dce5;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 0 3px 0 rgba(0, 0, 0, 0.04);
  .tags-view-item {
    display: inline-block;
    position: relative;
    height: 30px;
    line-height: 33px;
    border: 1px dashed #b1b1b1;
    color: #b1b1b1;
    padding: 0 8px;
    font-size: 14px;
    margin-left: 5px;
    border-radius: 5px;
    
    &:first-of-type {
      margin-left: 15px;
    }
    &.active {
      background-color: #20a0ff!important;
      color: #fff;
      border-color: #20a0ff!important;
      &::before {
        content: '';
        background: #fff;
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        position: relative;
        top: -1px;
        margin-right: 2px;
      }
    }
  }
}

</style>

<style rel="stylesheet/scss" lang="scss">
.m-b-10 {
  overflow: hidden;
  line-height: 35px;
}
.tags-view-container {
  .tags-view-item {
    .el-icon-close {
      position: relative;
      top: 2px;
      font-size :16px;
      width: 16px;
      height: 16px;
      vertical-align: 2px;
      border-radius: 50%;
      text-align: center;
      transition: all 0.3s cubic-bezier(0.645, 0.045, 0.355, 1);
      transform-origin: 100% 50%;
      
      &:hover {
        background-color: #b4bccc;
        color: #fff;
      }
    }
  }
}
</style>
