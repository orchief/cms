const apiMethods = {
    methods: {
        apiGet(url, data) {
            // console.log('url', url)
            // console.log('window.axios.defaults.headers.authorization', window.axios.defaults.headers.authorization)
            return new Promise((resolve, reject) => {
                axios.get(url, data).then((response) => {
                    this.resetAuth(response)
                    resolve(response.data)
                }, (response) => {
                    reject(response)
                    _g.closeGlobalLoading()
                    bus.$message({
                        message: '请求超时，请检查网络',
                        type: 'warning'
                    })
                })
            })
        },
        apiPost(url, data) {
            // console.log('url', url)

            return new Promise((resolve, reject) => {
                axios.post(url, data).then((response) => {
                    this.resetAuth(response)
                    resolve(response.data)
                }).catch((response) => {
                    resolve(response)
                    bus.$message({
                        message: '请求超时，请检查网络',
                        type: 'warning'
                    })
                })
            })
        },
        apiDelete(url, id) {
            // console.log('url', url)
            return new Promise((resolve, reject) => {
                axios.delete(url + id).then((response) => {
                    this.resetAuth(response)
                    resolve(response.data)
                }, (response) => {
                    reject(response)
                    _g.closeGlobalLoading()
                    bus.$message({
                        message: '请求超时，请检查网络',
                        type: 'warning'
                    })
                })
            })
        },
        apiPut(url, id, obj) {

            return new Promise((resolve, reject) => {
                axios.put(url + id, obj).then((response) => {
                    this.resetAuth(response)
                    resolve(response.data)
                }, (response) => {
                    _g.closeGlobalLoading()
                    bus.$message({
                        message: '请求超时，请检查网络',
                        type: 'warning'
                    })
                    reject(response)
                })
            })
        },
        handelResponse(res, cb, errCb) {

            _g.closeGlobalLoading()
            if (res.code === 200) {
                cb(res.data)
            } else {
                if (typeof errCb === 'function') {
                    errCb()
                }
                this.handleError(res)
            }
        },
        handleError(res) {
            if (res.code) {
                switch (res.code) {
                    case 101:
                        // console.log('cookie = ', Cookies.get('rememberPwd'))
                        if (Cookies.get('rememberPwd')) {
                            let data = {
                                rememberKey: window.sessionStorage.getItem('rememberKey')
                            }
                            this.reAjax('admin/base/relogin', data).then((res) => {
                                this.handelResponse(res, (data) => {
                                    this.resetCommonData(data)
                                })
                            })
                        } else {
                            _g.toastMsg('error', res.data.msg)
                            setTimeout(() => {
                                router.replace('/cms/login')
                            }, 1500)
                        }
                        break
                    case 103:
                        _g.toastMsg('error', res.data.msg)
                        setTimeout(() => {
                            router.replace('/cms/login')
                        }, 1500)
                        break
                        // case 400:
                        //   this.goback()
                        //   break
                    default:
                        _g.toastMsg('error', res.data.msg)
                }
            } else {
                console.log('default error')
            }
        },
        resetAuth(res) {
            if (res.headers.authorization) {
                window.sessionStorage.setItem('authorization', res.headers.authorization) // 用户sessionid
                window.axios.defaults.headers.authorization = res.headers.authorization
            }
        },
        resetCommonData(data) {
            _(data.menusList).forEach((res, key) => {
                    if (key === 0) {
                        res.selected = true
                    } else {
                        res.selected = false
                    }
                })
                // console.log('window.axios.headers.authorization', window.axios)
            window.sessionStorage.setItem('menus', JSON.stringify(data.menusList)) // 菜单数据
            window.sessionStorage.setItem('rememberKey', data.rememberKey) // 记住密码的加密字符串
            window.sessionStorage.setItem('authList', data.authList) // 权限节点列表
            window.sessionStorage.setItem('userInfo', JSON.stringify(data.userInfo)) // 用户信息
            let routerUrl = ''
            if (data.menusList[0].url) {
                routerUrl = data.menusList[0].url
            } else {
                routerUrl = data.menusList[0].child[0].url
            }
            let path = this.$route.path
            if (routerUrl !== path) {
                router.replace(routerUrl)
            } else {
                _g.shallowRefresh(this.$route.name)
            }
        },
        reAjax(url, data) {
            return new Promise((resolve, reject) => {
                axios.post(url, data).then((response) => {
                    resolve(response.data)
                }, (response) => {
                    reject(response)
                    bus.$message({
                        message: '请求超时，请检查网络',
                        type: 'warning'
                    })
                })
            })
        }
    },
    computed: {
        showLoading() {
            return store.state.globalLoading
        }
    }
}

export default apiMethods