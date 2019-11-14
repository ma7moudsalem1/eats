import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './store'
import Home from './views/Home'
import User from './views/User'
import Resturant from './views/Resturant'
import Item from './views/Item'
import Size from './views/Size'
import NotFound from './views/NotFound'
import common from '@/js/utils/common'

Vue.use(VueRouter)
let rootUrl = document.head.querySelector('meta[name="root-url"]').content;

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: rootUrl + 'home',
            name: 'home',
            component: Home
        },
        {
            path: rootUrl + 'sizes',
            name: 'size',
            component: Size
        },
        {
            path: rootUrl + 'items',
            name: 'item',
            component: Item
        },
        {
            path: rootUrl + 'resturants',
            name: 'resturant',
            component: Resturant
        },
        {
            path: rootUrl + 'users',
            name: 'user',
            component: User
        },
        {
            path: '*',
            name:'not-found',
            component: NotFound
        }
    ]
})
/*
const gatePages = [
    rootUrl + 'profile',

];

router.beforeEach((to, from, next) => {
    store.dispatch('setLoader', true)
    // Check
    var path = to.fullPath;

    // redirect to login page if not logged in and trying to access a restricted page
    if (!store.state.user.userToken && gatePages.indexOf(to.path) !== -1) {
       store.dispatch('setLoginDialog', true)
       return next(rootUrl+'login')
    }
    else{
        next();
    }

    if (store.state.user.userToken && to.path === rootUrl + 'login') {
        return next(rootUrl);
    }

    if (store.state.user.userToken && to.path === rootUrl + 'register') {
        return next(rootUrl);
    }

   })*/

export default router
