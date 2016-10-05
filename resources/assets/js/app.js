/**
 * Configure and instantiate root VueRouter instance
 */
import Vue from 'vue';
import VueResource from 'vue-resource';
import VueRouter from 'vue-router';

import Home from './components/Home.vue';
import Journals from './components/Journals.vue';

Vue.use(VueResource);
Vue.use(VueRouter);

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name=csrf-token]').content;

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
