<template>
	<div id="app">
		<transition name="bounce">
			<router-view></router-view>
		</transition>
	</div>
  
</template>
<script>
export default {
  name: "app",
  components: {},
  // sockets: {
  //   connect: function() {
  //     // 后端推送来消息时
  //     this.id = this.$socket.id
  //     console.log('id:', this.id)
  //   },
  //   customEmit: function(val) {
  //     console.log(
  //       'this method was fired by the socket server. eg: io.emit("customEmit", data)'
  //     )
  //   },
  //   new_msg: function(val) {
  //     // 调用弹窗
  //     const h = this.$createElement

  //     this.$notify({
  //       title: '新的申请',
  //       message: h('i', { style: 'color: teal' }, val),
  //       duration: 0
  //     })
  //   }
  // },
  created() {}
};
</script>

<style>
@import "assets/css/font-awesome.min.css";
@import "./assets/iconfont/iconfont.css";
.bounce-enter-active {
  animation: bounce-in 0.5s;
}

.bounce-leave-active {
  animation: bounce-out 0.2s;
}

@keyframes bounce-in {
  0% {
    transform: scale(0);
  }
  50% {
    transform: scale(1.05);
  }
  100% {
    transform: scale(1);
  }
}

@keyframes bounce-out {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(0.95);
  }
  100% {
    transform: scale(0);
  }
}

body {
  margin: 0px;
  padding: 0px;
  background: #f3f3f3;
  font-family: Helvetica Neue, Helvetica, PingFang SC, Hiragino Sans GB,
    Microsoft YaHei, SimSun, sans-serif;
  font-weight: 400;
  -webkit-font-smoothing: antialiased;
  /* user-select: none; */
}

#app {
  position: absolute;
  /* top: 0px; */
  bottom: 0px;
  width: 100%;
}

.el-submenu [class^="fa"] {
  vertical-align: baseline;
  margin-right: 10px;
}

.el-menu-item [class^="fa"] {
  vertical-align: baseline;
  margin-right: 10px;
}

.icon_button {
  margin-left: 10px;
}
.icon_button :hover {
  color: #20a0ff;
}

#nprogress .spinner-icon {
  width: 18px;
  height: 18px;
  box-sizing: border-box;

  border: solid 2px transparent;
  border-top-color: rgb(65, 8, 223) !important;
  border-left-color: rgb(65, 8, 223) !important;
  border-radius: 50%;

  -webkit-animation: nprogress-spinner 400ms linear infinite;
  animation: nprogress-spinner 400ms linear infinite;
}

#nprogress .bar {
  background: rgb(65, 8, 223) !important;

  position: fixed;
  z-index: 1031;
  /* top: 0; */
  /* left: 0; */

  width: 100%;
  height: 2px;
}

.el-button {
  padding: 9px 20px !important;
}

a.tags-view-item.router-link-exact-active.router-link-active.active {
  background-color: #20a0ff;
  color: #fff;
  border-color: #20a0ff;
}

.el-message--warning {
}

.el-message--success .el-message__content {
  color: #20a0ff !important;
}

.el-icon-success:before {
  color: #20a0ff !important;
}

.el-form-item.is-success .el-input__inner,
.el-form-item.is-success .el-input__inner:focus,
.el-form-item.is-success .el-textarea__inner,
.el-form-item.is-success .el-textarea__inner:focus {
  border-color: #20a0ff !important;
}
.tags-view-container .tags-view-item.active {
  background-color: #20a0ff !important;
  color: #fff;
  border-color: #20a0ff !important;
}

.content {
  background: rgb(225, 225, 225);
}

.el-submenu__title :hover {
  background: rgb(190, 190, 190) !important;
}

.panel-c-c .fl .el-button{
  margin-top:5px;
}
.el-table td, .el-table th.is-leaf{
  text-align:center;
}

.el-form-item__label{
  padding: 0;
}
</style>