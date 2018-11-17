<template>
	<div class="outer-container" :style="{height:this.height - 60 + 'px', width:180 + 'px'}">
		<div class="inner-container">
			<div class="content" :style="{height:this.height - 60 + 'px', width:190 + 'px'}">

				<el-menu :default-active="active" :collapse="isCollapse" :unique-opened="true"  active-text-color="#20a0ff">
					<template v-for="secMenu in menuData">
            <!-- 这里:index只能接收字符类型  假设后台返回的是int类型就需要进行类型转换  -->
							<el-submenu :index="secMenu.id+''" v-if="secMenu.child">
								<template slot="title">
									<icon :class="secMenu.icon + '-icon'" :name="secMenu.icon"></icon>
									<span>{{ secMenu.title }}</span>
								</template>
								<template v-for="item in secMenu.child">
									<el-menu-item :index="item.url" @click="routerChange(item)" v-bind:key="item.url">{{ item.title }}</el-menu-item>
								</template>
							</el-submenu>

							<el-menu-item v-else :index="secMenu.url" @click="routerChange(secMenu)" v-bind:key="secMenu.url">
								<icon :class="secMenu.icon + '-icon'" :name="secMenu.icon"></icon>
								<span>{{ secMenu.title }}</span>
							</el-menu-item>
					</template>
				</el-menu>
			
			</div>
		</div>
	</div>
</template>

<style>
.outer-container {
  position: relative;
  overflow: hidden;
}
.inner-container {
  position: absolute;
  left: 0;
  overflow-x: hidden;
  overflow-y: scroll;
}

/* for Chrome */
.inner-container::-webkit-scrollbar {
  display: none;
}

/* for svg icon */
[class^='svg-icon'],
[class*=' svg-icon'] {
  width: 14px;
  height: 14px;
  margin-right: 5px;
}
.el-submenu__title {
  color: #495060!important;
}
.content {
  background: #fff;
}
.el-menu-item.is-active {
  background: #f7f7f7!important;
}
.el-submenu__title :hover{
  background:none!important;
}
.el-submenu .el-menu-item.is-active:after, 
.el-submenu .el-menu-item.is-active:after{
  position: absolute;
  top: 14px;
  left: 30px;
  content: '';
  width:3px;
  height: 20px;
  background: #0091ea;
}
</style>

<script>
export default {
  name: 'leftMenu',
  props: ['menuData', 'menu', 'isCollapse'],
  data() {
    return {
      height: document.documentElement.clientHeight,
      active: ''
    }
  },
  methods: {
    routerChange(item) {
      _g.openGlobalLoading()
      // 与当前页面路由相等则刷新页面
      if (item.url !== this.$route.path) {
        router.push(item.url)
      } else {
        _g.shallowRefresh(this.$route.name)
      }
    },
    init() {
      this.height = document.documentElement.clientHeight
    }
  },
  mounted() {
    const that = this
    window.onresize = () => {
      return (() => {
        window.screenWidth = document.documentElement.clientHeight
        that.height = window.screenWidth
      })()
    }
    // 延迟绑定监听
    this.$watch('$route', {
      deep: true,
      handler: function() {
        this.active = this.$route.path
        // console.log('data:', this.active)
      }
    })
  },
  watch: {
    height(val) {
      this.height = val
      this.height
    }
  },
  created() {
    this.active = this.$route.path
    this.init()
  }
}
</script>
