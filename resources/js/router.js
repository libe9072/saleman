import Vue from 'vue'
import Router from 'vue-router'
import Sample from "./components/layout/Sample";

Vue.use(Router)

export default new Router({
  mode: 'hash',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'sample',
      component: Sample,
    },
  ]
})
