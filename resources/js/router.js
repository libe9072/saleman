import Vue from 'vue'
import Router from 'vue-router'
import { Auth } from './api'
import Login from "./components/layout/Login";
import SearchList from "./components/layout/SearchList";

Vue.use(Router)

const requireAuth = async (to, from, next) => {
  if (await Auth.loggedIn()) {
    return next()
  }
  next({
    path: '/login',
    query: { redirect: to.fullPath }
  })
}
export default new Router({
  mode: 'hash',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/login',
      name: 'Login',
      component: Login,
    },
    {
      path: '/', beforeEnter: requireAuth,
      name: 'searchlist',
      component: SearchList,
    },
  ]
})
