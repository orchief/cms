import 'babel-polyfill'
import Vue from 'vue'
import App from './App'
import axios from 'axios'
import Lockr from 'lockr'
import Cookies from 'js-cookie'
import _ from 'lodash'
import moment from 'moment'
import ElementUI from 'element-ui'
// import TableModel from 'mypk'
import 'element-ui/lib/theme-chalk/index.css'
import routes from './router/routes'
import VueRouter from 'vue-router'
import store from './vuex/store'
import filter from './assets/js/filter'
import _g from './assets/js/global'
import NProgress from 'nprogress'
import 'nprogress/nprogress.css'
import 'assets/css/global.css'
import 'assets/css/base.css'
import Icon from 'vue-svg-icon/Icon.vue'
import $ from 'jquery'

import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.js'

import config from './config.js'
axios.defaults.baseURL = config.axios.defaults.baseURL
axios.defaults.timeout = config.axios.defaults.timeout
axios.defaults.headers.authorization = window.sessionStorage.getItem('authorization')
axios.defaults.headers['Content-Type'] = 'application/json'
axios.defaults.withCredentials = config.axios.defaults.withCredentials
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded'

const router = new VueRouter({
    mode: 'history',
    base: __dirname,
    routes
})

router.beforeEach((to, from, next) => {
    const hideLeft = to.meta.hideLeft
    store.dispatch('showLeftMenu', hideLeft)
    store.dispatch('showLoading', true)
    NProgress.start()
    next()
})

router.afterEach(transition => {
    NProgress.done()
})

Vue.use(ElementUI)
    // Vue.use(mypk)
Vue.use(VueRouter)
    // Vue.use(VueSocketio, 'http://szt.pstech360.com:2021')
Vue.component('icon', Icon)

import VueQuillEditor from 'vue-quill-editor'
// require styles 引入样式
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'

Vue.use(VueQuillEditor)

window.router = router
window.store = store
window.HOST = HOST
window.ResourceBaseUrl = config.ResourceBaseUrl
window.axios = axios
window._ = _
window.moment = moment
window.Lockr = Lockr
window.Cookies = Cookies
window._g = _g
window.pageSize = 15

const bus = new Vue()
window.bus = bus

new Vue({
    el: '#app',
    template: '<App/>',
    filters: filter,
    router,
    store,
    components: { App }
    // render: h => h(Login)
}).$mount('#app')