/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
const fa_library = require('@fortawesome/fontawesome-svg-core').library;
const fa_regular = require('@fortawesome/free-regular-svg-icons').far;
const fa_solid   = require('@fortawesome/free-solid-svg-icons').fas;
const fa_vue     = require('@fortawesome/vue-fontawesome').FontAwesomeIcon;
fa_library.add(fa_regular, fa_solid);
Vue.component('fa', fa_vue);

const BootstrapVue = require('bootstrap-vue');
Vue.use(BootstrapVue);

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const VueApp = require('./App.vue').default;
const app    = new Vue({
    el:         '#app',
    components: {VueApp},
    render(h) { return h(VueApp); }
});
