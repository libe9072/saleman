import Vue from 'vue'
import Router from 'vue-router'
import Login from "./components/layout/Login";
import SearchList from "./components/layout/SearchList";

Vue.use(Router)

export default new Router({
  mode: 'hash',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'Login',
      component: SearchList,
    },
  ]
})
