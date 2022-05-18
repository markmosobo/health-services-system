/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import VueRouter from 'vue-router'

Vue.use(VueRouter)

let routes = [
    { path: '/home', component: require('./components/Dashboard.vue').default },
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/doctors', component: require('./components/Doctor.vue').default },
    { path: '/patients', component: require('./components/Patient.vue').default },
    { path: '/patientvitals', component: require('./components/PatientVitals.vue').default },
    { path: '/rooms', component: require('./components/Room.vue').default },
    { path: '/consultation', component: require('./components/Consultation.vue').default },
    { path: '/labs', component: require('./components/Lab.vue').default },
    { path: '/labtest', component: require('./components/LabTest.vue').default },
    { path: '/prescription', component: require('./components/Prescription.vue').default },
    { path: '/pendinglab', component: require('./components/PendingLab.vue').default },
    { path: '/pendingprescription', component: require('./components/PendingPrescription.vue').default },
    { path: '/pendingdrugpurchase', component: require('./components/PendingDrugPurchases.vue').default },
    { path: '/inpatients', component: require('./components/Inpatient.vue').default },
    { path: '/outpatients', component: require('./components/Outpatient.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/users', component: require('./components/User.vue').default },
    { path: '/drugs', component: require('./components/Drug.vue').default },
    { path: '/drugsales', component: require('./components/DrugSale.vue').default },
    { path: '/pharmacists', component: require('./components/Pharmacist.vue').default },
    { path: '/accountants', component: require('./components/Accountant.vue').default },
    { path: '/staff', component: require('./components/Staff.vue').default },
    { path: '/messages', component: require('./components/Message.vue').default },
    { path: '/analytics', component: require('./components/Analytics.vue').default },
    { path: '/bills', component: require('./components/Bill.vue').default },
    { path: '/payment', component: require('./components/Payment.vue').default },
    { path: '/notifications', component: require('./components/Notification.vue').default },
    { path: '*', component: require('./components/NotFound.vue').default }

  ]

const router = new VueRouter({
    mode: 'history',
    routes 
  }); 

  //using vform
  import Form from 'vform';
  window.Form = Form;

  //custom event
window.Fire = new Vue();

//progressbar
import VueProgressBar from 'vue-progressbar';
Vue.use(VueProgressBar,{
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '3px'
});

//sweetalert2
import Swal from 'sweetalert2';
window.Swal = Swal;

const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

window.toast = toast;

//gates
import Gate from './Gate';
Vue.prototype.$gate = new Gate(window.user);

import moment from 'moment';
import axios from 'axios';

//filters
Vue.filter('monthDateTime',function(date){
  return moment(date).format('MMM Do YYYY')
});

Vue.filter('capitalizeFirstLetter',function(text){
  return text.charAt(0).toUpperCase() + text.slice(1)
}); 

Vue.filter('formatDate', function(date) {
  if (date) {
    return moment(String(date)).format('DD MMM hh:mm a')
  }
});

//find loggedin user id
Vue.prototype.$userId = document.querySelector("meta[name='currentuser_id']").getAttribute('content');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
//pagination
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('no-pending-task', require('./components/NoPendingTask.vue').default);
Vue.component('not-found', require('./components/NotFound.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#hosp',
    router, 
});
