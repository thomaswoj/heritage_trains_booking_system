
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.EventBus = new Vue;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Booking States
Vue.component('start-booking', require('./components/frontend/booking_states/StartBooking.vue').default);
Vue.component('choose-passenger-count', require('./components/frontend/booking_states/ChoosePassengerCount.vue').default);
Vue.component('choose-journeys', require('./components/frontend/booking_states/ChooseJourneys.vue').default);
Vue.component('enter-passenger-names', require('./components/frontend/booking_states/EnterPassengerNames.vue').default);


Vue.component('vue-keyboard', require('./components/frontend/VueKeyboard.vue').default);

// Main Booking Logic
Vue.component('booking', require('./components/frontend/Booking.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
