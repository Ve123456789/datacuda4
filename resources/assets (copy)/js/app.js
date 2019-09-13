require('./bootstrap');

import router from './routes.js';

import Auth from './auth.js';
import VueFlashMessage from 'vue-flash-message';
import VeeValidate from 'vee-validate';
import VueSession from 'vue-session'
import VModal from 'vue-js-modal'
import VueImg from 'v-img';
import VueProgressBar from 'vue-progressbar';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faCoffee } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import VueVideoPlayer from 'vue-video-player';
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import moment from 'moment';
import VueCookies from 'vue-cookies'
import VueSweetalert2 from 'vue-sweetalert2';



Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format("MMM, d YYYY")
    }
});
Vue.filter('formatDateTime', function(value) {
    if (value) {
        return moment(String(value)).format("MMM, d YYYY hh:mm:ss")
    }
});

// require videojs style
import 'video.js/dist/video-js.css';
// import 'vue-video-player/src/custom-theme.css'
Vue.use(VueSession);

Vue.use(VueVideoPlayer, /* {
  options: global default options,
  events: global videojs events
} */);
library.add(faCoffee);

Vue.component('font-awesome-icon', FontAwesomeIcon);

Vue.config.productionTip = false;

Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '2px'
});


Vue.use(VueImg);
Vue.use(VModal);

// You need a specific loader for CSS files like https://github.com/webpack/css-loader
Vue.use(VueFlashMessage, {
    messageOptions: {
        timeout: 2000
    }
});

Vue.use(VeeValidate);
Vue.use(BootstrapVue);
Vue.use(VueCookies);
Vue.use(VueSweetalert2);

//import Api from './api.js';

window.auth = new Auth();
window.Event = new Vue;
//window.api = new Api();
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */



//require('../../../node_modules/vue-router');

//window.Vue = require('vue');

//Vue.use(VueRouter);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('vue-layout', require('./components/Common/Layout.vue'));
Vue.component('vue-reset-layout', require('./components/Auth/ResetPasswordLayout.vue'));
const app = new Vue({
    el: '#app',
    router,mounted () {
        //  [App.vue specific] When App.vue is finish loading finish the progress bar
        this.$Progress.finish()
    },
    created () {
        //  [App.vue specific] When App.vue is first loaded start the progress bar
        this.$Progress.start()
        //  hook the progress bar to start before we move router-view
        this.$router.beforeEach((to, from, next) => {
            //  does the page we want to go to have a meta.progress object
            if (to.meta.progress !== undefined) {
                // parse meta tags
                this.$Progress.parseMeta(meta)
            }
            //  start the progress bar
            this.$Progress.start()
            //  continue to next page
            next()
        })
        //  hook the progress bar to finish after we've finished moving router-view
        this.$router.afterEach((to, from) => {
            //  finish the progress bar
            this.$Progress.finish()
        })
    }
});
