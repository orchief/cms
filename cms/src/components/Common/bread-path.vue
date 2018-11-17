<template>
<el-breadcrumb separator="/" class="app-breadcrumb">
<transition-group tag="span" name="breadcrumb">
  <el-breadcrumb-item v-if="levelList[0].meta" :key="levelList[0].meta.moduleName">{{levelList[0].meta.moduleName}}</el-breadcrumb-item>
  <el-breadcrumb-item :key="levelList[0].name" v-if="levelList[0].name !== 'dashboard'">{{ levelList[0].name }}</el-breadcrumb-item>
  <el-breadcrumb-item v-if="levelList[1].meta" :key="item"  v-for="item in levelList[1].meta.path">{{ item }}</el-breadcrumb-item>
  <el-breadcrumb-item :key="levelList[1].name">{{ levelList[1].name }}</el-breadcrumb-item>
</transition-group>  
</el-breadcrumb>
</template>

<script>
export default {
  props: ['levelList']
}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.app-breadcrumb.el-breadcrumb {
  display: inline-block;
  font-size: 14px;
  margin-left: 10px;
  .no-redirect {
    color: #97a8be;
    cursor: text;
  }
  /*fade*/
.breadcrumb-enter-active,
.breadcrumb-leave-active {
  transition: all .5s;
}

.breadcrumb-enter,
.breadcrumb-leave-active {
  opacity: 0;
  transform: translateX(20px);
}

.breadcrumb-move {
  transition: all .5s;
}

.breadcrumb-leave-active {
  position: absolute;
}
}
</style>
