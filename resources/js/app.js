/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue'
import vuetify from './plugins/vuetify'
import App from './App.vue'
import router from './router'
import { store } from "./store";

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
/**
 * 202-0-01-06 sukjada81 동급 컴포넌트 통신을 위해 eventBus 추가
 * */
const app = new Vue({
  router,
  vuetify,
  store: store,
  render: h => h(App)
}).$mount('#app')
