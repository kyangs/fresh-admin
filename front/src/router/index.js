import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

/* Layout */
import Layout from '@/layout'

/* Router Modules */

/**
 * Note: sub-menu only appear when route children.length >= 1
 * Detail see: https://panjiachen.github.io/vue-element-admin-site/guide/essentials/router-and-nav.html
 *
 * hidden: true                   if set true, item will not show in the sidebar(default is false)
 * alwaysShow: true               if set true, will always show the root menu
 *                                if not set alwaysShow, when item has more than one children route,
 *                                it will becomes nested mode, otherwise not show the root menu
 * redirect: noRedirect           if set noRedirect will no redirect in the breadcrumb
 * name:'router-name'             the name is used by <keep-alive> (must set!!!)
 * meta : {
    roles: ['admin','editor']    control the page roles (you can set multiple roles)
    title: 'title'               the name show in sidebar and breadcrumb (recommend set)
    icon: 'svg-name'             the icon show in the sidebar
    noCache: true                if set true, the page will no be cached(default is false)
    affix: true                  if set true, the tag will affix in the tags-view
    breadcrumb: false            if set false, the item will hidden in breadcrumb(default is true)
    activeMenu: '/example/list'  if set path, the sidebar will highlight the path you set
  }
 */

/**
 * constantRoutes
 * a base page that does not have permission requirements
 * all roles can be accessed
 */
export const constantRoutes = [
  {
    path: '/redirect',
    component: Layout,
    hidden: true,
    children: [
      {
        path: '/redirect/:path*',
        component: () => import('@/views/redirect/index')
      }
    ]
  },
  {
    path: '/login',
    component: () => import('@/views/login/index'),
    hidden: true
  },
  {
    path: '/404',
    component: () => import('@/views/error-page/404'),
    hidden: true
  },
  {
    path: '/401',
    component: () => import('@/views/error-page/401'),
    hidden: true
  },
  {
    path: '/',
    component: Layout,
    redirect: '/dashboard',
    children: [
      {
        path: 'dashboard',
        component: () => import('@/views/dashboard/index'),
        name: 'Dashboard',
        meta: { title: '系统首页', icon: 'dashboard', affix: true }
      }
    ]
  },
  {
    path: '/manage/info',
    component: Layout,
    hidden: true,
    children: [
      {
        path: '/manage/info',
        component: () => import('@/views/manage/info'),
        name: 'manage/info',
        meta: { title: '我的资料', icon: 'user' }
      }
    ]
  },
  {
    path: '/adv/list',
    component: Layout,
    hidden: true,
    children: [
      {
        path: '/adv/list',
        component: () => import('@/views/adv/list'),
        name: '/adv/list/',
        meta: { title: '广告列表', icon: 'dashboard' }
      }
    ]
  },
  {
    path: '/category/list',
    component: Layout,
    hidden: true,
    children: [
      {
        path: '/category/list',
        component: () => import('@/views/category/list'),
        name: '/category/list/',
        meta: { title: '分类列表', icon: 'dashboard' }
      }
    ]
  },
  {
    path: '/system_notice/list',
    component: Layout,
    hidden: true,
    children: [
      {
        path: '/system_notice/list',
        component: () => import('@/views/system_notice/list'),
        name: '/system_notice/list/',
        meta: { title: '公告列表', icon: 'dashboard' }
      }
    ]
  },
  {
    path: '/goods/list',
    component: Layout,
    hidden: true,
    children: [
      {
        path: '/goods/list',
        component: () => import('@/views/goods/list'),
        name: '/goods/list/',
        meta: { title: '商品列表', icon: 'dashboard' }
      },
      {
        path: '/goods/create',
        component: () => import('@/views/goods/create'),
        name: '/goods/create/',
        meta: { title: '添加商品', icon: 'form' }
      }
    ]
  },
  {
    path: '/system_setting',
    component: Layout,
    hidden: true,
    children: [
      {
        path: '/system_setting/upload',
        component: () => import('@/views/system_setting/upload_setting'),
        name: '/system_setting/upload/',
        meta: { title: '商品列表', icon: 'dashboard' }
      },
    ]
  }
]

const createRouter = () => new Router({
  // mode: 'history', // require service support
  scrollBehavior: () => ({ y: 0 }),
  routes: constantRoutes
})

const router = createRouter()

// Detail see: https://github.com/vuejs/vue-router/issues/1234#issuecomment-357941465
export function resetRouter() {
  const newRouter = createRouter()
  router.matcher = newRouter.matcher // reset router
}

export default router
