
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue'
import VueRouter from 'vue-router'

import {routes} from './routes/routes'

Vue.use(VueRouter);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component(
    'example-component', require('./components/ExampleComponent.vue')
);
Vue.component(
    'app-posts', require('./components/Posts.vue')
);
Vue.component(
    'app-navbar', require('./components/Navbar.vue')
);

let Myheader = require('./components/phonebook/Myheader.vue');
let Myfooter = require('./components/phonebook/Myfooter.vue');
let Home = require('./components/phonebook/Home.vue');
let About = require('./components/phonebook/About.vue');

const router = new VueRouter({
    // mode: 'history',
    routes
  });

const app = new Vue({
    el: '#app',
    router,
    components: {
        Myheader,
        Myfooter
    }
});
