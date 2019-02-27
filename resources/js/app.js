
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
Vue.component('choose-journeys', require('./components/frontend/booking_states/journey/ChooseJourneys.vue').default);
Vue.component('journey-table', require('./components/frontend/booking_states/journey/JourneyTable.vue').default);
Vue.component('enter-passenger-names', require('./components/frontend/booking_states/EnterPassengerNames.vue').default);
Vue.component('finalize-booking', require('./components/frontend/booking_states/finalize/FinalizeBooking.vue').default);
Vue.component('ticket-card', require('./components/frontend/booking_states/finalize/TicketCard.vue').default);

// Utility Components
Vue.component('vue-keyboard', require('./components/frontend/VueKeyboard.vue').default);
Vue.component('cancel-booking', require('./components/frontend/CancelBooking.vue').default);

// Main Booking Logic
Vue.component('booking', require('./components/frontend/Booking.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.bootbox = require('bootbox');
const app = new Vue({
    el: '#app'
});
