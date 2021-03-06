/**
 * Import the plugins and dependencies for Vue
 */
import Vue from 'vue';
import VueResource from 'vue-resource';
import VueRouter from 'vue-router';

/**
 * Import custom Vue filters.
 */
import { formatDate } from './filters/moment.js';

/**
 * Import services.
 */
import auth from './services/auth';

/**
 * Import the components.
 */
import App from './components/App.vue';
import Home from './components/Home.vue';
import Login from './components/Login.vue';
import Journal from './components/Journal.vue';

/**
 * Import other vendor packages.
 */
import _ from 'lodash';
window._ = _;

/**
 * Configure Vue instance.
 */
Vue.use(VueResource);
Vue.use(VueRouter);
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name=csrf-token]').content;

/**
 * Register custom filters.
 */
Vue.filter('formatDate', formatDate);

/**
 * Initialize empty Vue instance for events propagation.
 */
window.eventBus = new Vue();

const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', component: Home, },
        { path: '/login', component: Login, },
        { path: '/journals', redirect: { name: 'volume' }, },
        { path: '/journals/volume/:volume?', name: 'volume', component: Journal },
    ],
});

/**
 * Check if the user is authenticated, and then mount the app.
 */
auth.check(Vue)
    .then(({body}) => {
        auth.user.data = body;
        auth.user.isAuthenticated = true;
    })
    .finally(() => {
        Vue.component('app', App);
        const app = new Vue({
            router,
            template: `<app></app>`,
        }).$mount('#app');
    });
