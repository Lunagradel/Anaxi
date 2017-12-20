
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import router from './routes';
 /**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('desktop-nav', require('./components/DesktopNav.vue'));
Vue.component('sign-up', require('./components/SignUp.vue'));
Vue.component('login', require('./components/Login.vue'));

new Vue({
    el: '#app',
    data:{
      store: {
        user: {
          name: "",
          id: "",
        },
        experienceToStore: {
          latitude: "",
          longitude: "",
          locationName: "",
          description: "",
          recommended: false
        },
      },
    },
    mounted(){
      let userId = document.head.querySelector("[name=user]").content;
      this.store.user.id = userId;
    },
    router
});
