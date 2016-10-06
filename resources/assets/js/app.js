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
 * Import the components.
 */
import Home from './components/Home.vue';
import Journals from './components/Journals.vue';

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
        { path: '/journals', redirect: { name: 'volume' }, },
        { path: '/journals/volume/:volume?', name: 'volume', component: Journals },
    ],
});

const app = new Vue({
    router,
}).$mount('#app');
