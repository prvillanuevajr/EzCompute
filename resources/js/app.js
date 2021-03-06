/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.Highcharts = require('./highchart');
window.Moment = require('moment');
window.topeso = (num) => '₱' + Number(num).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
require('./bootstrap');
require('./bootstrap-datepicker');
window.Vue = require('vue');
window.Swal = require('sweetalert2');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
import StarRating from 'vue-star-rating'

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('catalouge', require('./components/Catalouge.vue').default);
Vue.component('cart', require('./components/Cart.vue').default);
Vue.component('ratings', require('./components/Ratings.vue').default);
Vue.component('notifications', require('./components/Notifications').default);
Vue.component('star-rating', StarRating);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
