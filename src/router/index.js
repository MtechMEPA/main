import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Login from '../views/Login.vue'
import RegistrationRelawan from '../views/RegistrationRelawan.vue'
import RegistrationPemilih from '../views/RegistrationPemilih.vue'
import CompletionRelawan from '../views/CompletionRelawan.vue'
import CompletionPemilih from '../views/CompletionPemilih.vue'


import Logout from '../views/Logout.vue'
import Notfound from '../views/Notfound.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    beforeEnter: (to, from, next) => {  
      const userDetails = JSON.parse(localStorage.getItem('userDetails'));

      if (localStorage.getItem('token') == null || userDetails.status == 'inactive') {
        next({
          path: '/logout',
          replace: true
        });
      } else {
        next();
      }
    }
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
    beforeEnter: (to, from, next) => {
      if (localStorage.getItem('token') != null) {
        next({
          path: '/',
          replace: true
        });
      } else {
        next();
      }
    }
  },
  {
    path: '/registration-relawan',
    name: 'Registration Relawan',
    component: RegistrationRelawan,
    beforeEnter: (to, from, next) => {
      if (localStorage.getItem('token') != null) {
        next({
          path: '/',
          replace: true
        });
      } else {
        next();
      }
    }
  },
  {
    path: '/registration-pemilih',
    name: 'Registration Pemilih',
    component: RegistrationPemilih,
    beforeEnter: (to, from, next) => {
      if (localStorage.getItem('token') != null) {
        next({
          path: '/',
          replace: true
        });
      } else {
        next();
      }
    }
  },
  {
    path: '/logout',
    name: 'Logout',
    component: Logout 
  },
  {
    path: '/completion-relawan',
    name: 'Completion Relawan',
    component: CompletionRelawan,
    beforeEnter: (to, from, next) => {
      if (localStorage.getItem('token') == null) {
        next({
          path: '/login',
          replace: true
        });
      } else {
        next();
      }
    }
  },
  {
    path: '/completion-pemilih',
    name: 'Completion Pemilih',
    component: CompletionPemilih,
    beforeEnter: (to, from, next) => {
      if (localStorage.getItem('token') == null) {
        next({
          path: '/login',
          replace: true
        });
      } else {
        next();
      }
    }
  },
  {
    path: "/:catchAll(.*)",
    name: 'Notfound',
    component: Notfound,
    beforeEnter: (to, from, next) => {
      next({
        path: '/login',
        replace: true
      });
    }
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
