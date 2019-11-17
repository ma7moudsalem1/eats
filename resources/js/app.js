import './bootstrap'
import Vue from 'vue'
import store from './store'

import Routes from '@/js/routes.js'

import App from '@/js/views/App'
import '@/js/plugins/axios'
import lsSync from '@/js/utils/localStorageHandler'
import Swal from 'sweetalert2'
import common from '@/js/utils/common'
//require('./bootstrap');

window.Vue = require('vue');
window.Swal = Swal

window.funcs = common;
const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

window.toast = toast
window.Fire = new Vue();
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));

lsSync.syncData();



window.onload = function () {
    Vue.prototype.$http.get('/auth').then(response => {
        window.Auth = response.data.auth;
        const app = new Vue ({
            el: '#app',
            store,
            router: Routes,
            render: h => h(App)
        })
    });
}
