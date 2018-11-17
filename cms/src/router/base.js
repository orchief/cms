// 登录
import Login from '../views/login'
// 后台首页
import Dashboard from '../views/Administrative/dashboard/index.vue'
// 页面刷新
import refresh from '../views/layout/refresh.vue'
// 后台主框架
import Home from '../views/layout/Home.vue'
// 菜单管理
import menuList from '../views/Administrative/system/menu/list.vue'
import menuAdd from '../views/Administrative/system/menu/add.vue'
import menuEdit from '../views/Administrative/system/menu/edit.vue'
// 系统参数
import systemConfig from '../views/Administrative/system/config/add.vue'
// 权限管理
import ruleList from '../views/Administrative/system/rule/list.vue'
import ruleAdd from '../views/Administrative/system/rule/add.vue'
import ruleEdit from '../views/Administrative/system/rule/edit.vue'
// 角色管理
import groupsAdd from '../views/Administrative/structures/groups/add.vue'
import groupsEdit from '../views/Administrative/structures/groups/edit.vue'
import groupsList from '../views/Administrative/structures/groups/list.vue'
// 管理员管理
import usersList from '../views/Administrative/accounts/admin/list.vue'
import usersAdd from '../views/Administrative/accounts/admin/add.vue'
import usersEdit from '../views/Administrative/accounts/admin/edit.vue'
// 登录日志
import signlogList from '../views/Administrative/system/signlog/list.vue'

/**
 * meta参数解析
 * hideLeft: 是 否隐藏左侧菜单，单页菜单为true
 * module: 菜单所属模块
 * menu: 所属菜单，用于判断三级菜单是否显示高亮，如菜单列表、添加菜单、编辑菜单都是'menu'，用户列表、添加用户、编辑用户都是'user'，如此类推
 */

const baseRoutes = [{
        //
        path: '/',
        redirect: '/cms/home/dashboard/list'
    }, {
        path: '/cms/login',
        component: Login
    },
    {
        path: '/cms/home',
        component: Home,
        children: [{ path: '/refresh', component: refresh, name: 'refresh' }]
    },
    {
        path: '/cms/home',
        component: Home,
        name: 'dashboard',
        meta: { moduleName: '系统' },
        children: [{
            path: 'dashboard/list',
            component: Dashboard,
            name: '后台首页',
            meta: {
                hideLeft: false,
                module: 'Administrative',
                menu: 'menu',
                path: []
            }
        }]
    },
    {
        path: '/cms/home',
        component: Home,
        name: '系统配置',
        meta: { moduleName: '系统' },
        children: [{
                path: 'menu/list',
                component: menuList,
                name: '菜单管理',
                meta: { hideLeft: false, module: 'Administrative', menu: 'menu' }
            },
            {
                path: 'menu/add',
                component: menuAdd,
                name: '添加菜单',
                meta: {
                    hideLeft: false,
                    module: 'Administrative',
                    menu: 'menu',
                    path: ['菜单管理']
                }
            },
            {
                path: 'menu/edit/:id',
                component: menuEdit,
                name: '编辑菜单',
                meta: {
                    hideLeft: false,
                    module: 'Administrative',
                    menu: 'menu',
                    path: ['菜单管理']
                }
            },
            {
                path: 'config/add',
                component: systemConfig,
                name: '系统参数',
                meta: {
                    hideLeft: false,
                    module: 'Administrative',
                    menu: 'systemConfig'
                }
            },
            {
                path: 'rule/list',
                component: ruleList,
                name: '权限规则',
                meta: { hideLeft: false, module: 'Administrative', menu: 'rule' }
            },
            {
                path: 'rule/add',
                component: ruleAdd,
                name: '添加权限',
                meta: {
                    hideLeft: false,
                    module: 'Administrative',
                    menu: 'rule',
                    path: ['权限规则']
                }
            },
            {
                path: 'rule/edit/:id',
                component: ruleEdit,
                name: '编辑权限',
                meta: {
                    hideLeft: false,
                    module: 'Administrative',
                    menu: 'rule',
                    path: ['权限规则']
                }
            },
            {
                path: 'signlog/list',
                component: signlogList,
                name: '登陆日志',
                meta: { hideLeft: false, module: 'Administrative', menu: 'signlog' }
            }
        ]
    },
    {
        path: '/cms/home',
        component: Home,
        name: '组织架构',
        meta: { moduleName: '系统' },
        children: [{
                path: 'groups/list',
                component: groupsList,
                name: '角色管理',
                meta: { hideLeft: false, module: 'Administrative', menu: 'groups' }
            },
            {
                path: 'groups/add',
                component: groupsAdd,
                name: '添加角色',
                meta: {
                    hideLeft: false,
                    module: 'Administrative',
                    menu: 'groups',
                    path: ['角色管理']
                }
            },
            {
                path: 'groups/edit/:id',
                component: groupsEdit,
                name: '编辑角色',
                meta: {
                    hideLeft: false,
                    module: 'Administrative',
                    menu: 'groups',
                    path: ['角色管理']
                }
            }
        ]
    },
    {
        path: '/cms/home',
        component: Home,
        name: '账户管理',
        meta: { moduleName: '系统' },
        children: [{
                path: 'users/list',
                component: usersList,
                name: '管 理 员',
                meta: { hideLeft: false, module: 'Administrative', menu: 'users' }
            },
            {
                path: 'users/add',
                component: usersAdd,
                name: '添加账户',
                meta: {
                    hideLeft: false,
                    module: 'Administrative',
                    menu: 'users',
                    path: ['管 理 员']
                }
            },
            {
                path: 'users/edit/:id',
                component: usersEdit,
                name: '编辑账户',
                meta: {
                    hideLeft: false,
                    module: 'Administrative',
                    menu: 'users',
                    path: ['管 理 员']
                }
            }
        ]
    },
    {
        path: '*',
        component: Error
    }
]

export default baseRoutes