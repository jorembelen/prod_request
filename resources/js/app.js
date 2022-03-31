require('./bootstrap')
require('datatables')

window.$ = require('jquery')
window.WOW = require('wowjs').WOW
window.swal = require('sweetalert2')
window.toastr = require('toastr')
window.Vue = Vue
window.datepicker = require('../../public/plugins/bootstrap-datepicker/js/bootstrap-datepicker')

import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'
import { routes } from './routes'
import store from './store'
import MainApp from './components/MainApp'
import { initialize } from './helpers/general'
import { loadProgressBar } from 'axios-progress-bar'
import VeeValidate from 'vee-validate'
import VueMeta from 'vue-meta'

Vue.use(VeeValidate)
Vue.use(VueRouter)
Vue.use(Vuex)
Vue.use(VueMeta, {
    // optional pluginOptions
    refreshOnceOnNavigation: true
})

const router = new VueRouter({
    mode: 'history',
    routes
})

initialize(store, router)

loadProgressBar()

export const bus = new Vue();

const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        MainApp
    }
})
