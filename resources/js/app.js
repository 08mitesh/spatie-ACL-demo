require('./bootstrap');
window.Vue = require('vue');
window.Fire = new Vue();
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

// import { defineAbility } from '@casl/ability';
// Vue.use(defineAbility)
// import { Can } from '@casl/vue';
// Vue.component('Can', Can);

import Multiselect from 'vue-multiselect'
Vue.component('multiselect', Multiselect)

require('../components');

import moment from 'moment';

Vue.filter("date",function(created){
  return moment(created).format('MMMM Do YYYY, h:mm:ss a');
})

// ES6 Modules or TypeScript Sweet alert
import Swal from 'sweetalert2'
window.swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })
  window.toast = Toast;

import { Form, HasError, AlertError } from 'vform'
window.Form = Form
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)


//Pagination 
Vue.component('pagination', require('laravel-vue-pagination'));


// import Permissions from '../assets/js/mixins/Permissions';
// Vue.mixin(Permissions);

  const app = new Vue({
    el:'#app'
});