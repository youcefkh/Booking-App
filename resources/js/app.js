require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex'
import storeDefinition from './store'
import router from './routes'
import moment from 'moment'
import Success from './shared/components/Success.vue'
import FatalError from './shared/components/FatalError.vue'
import StarRating from './shared/components/StarRating.vue'

import Index from './Index.vue'
import axios from 'axios';


window.Vue = require('vue').default;

Vue.use(VueRouter)
Vue.use(Vuex)
Vue.filter("fromNow", value => moment(value).fromNow())

Vue.component('star-rating', StarRating)
Vue.component('fatal-error', FatalError)
Vue.component('success', Success)
Vue.component('pagination', require('laravel-vue-pagination'));

const store = new Vuex.Store(storeDefinition)

//handle session expiring
window.axios.interceptors.response.use(
    response => response,
    error => {
        if(error.response.status == 401){
            store.dispatch('logout');
        }

        return Promise.reject(error);
    }
)
const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        index : Index
    },
    async beforeCreate(){
        this.$store.dispatch("loadStoredState");
        this.$store.dispatch('loadUser')
    }
});