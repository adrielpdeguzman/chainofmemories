/**
 * Bootstrap application dependencies.
 */
window._ = require('lodash');

/**
 * Vue configurations.
 * @type {[type]}
 */
window.Vue = require('vue');
require('vue-resource');
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name=csrf-token]').content;

/**
 * Instantiate the root Vue instance.
 */
const app = new Vue({
  el: '#app',
});
