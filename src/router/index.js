import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Login from '../views/Login.vue'
import RegistrationRelawan from '../views/RegistrationRelawan.vue'
import RegistrationPemilih from '../views/RegistrationPemilih.vue'
import CompletionRelawan from '../views/CompletionRelawan.vue'
import CompletionPemilih from '../views/CompletionPemilih.vue'
import ProfilePemilih from '../views/ProfilePemilih.vue'
import ProfileRelawan from '../views/ProfileRelawan.vue'
import ProfileAdmin from '../views/ProfileAdmin.vue'
import Logout from '../views/Logout.vue'
import Notfound from '../views/Notfound.vue'
import store from '../store'; // Import store
import { isTokenExpired } from '@/auth/tokenValidate'; // Import fungsi utilitas

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    meta: { requiresAuth: true, roles: ['relawan', 'pemilih', 'admin'] }
  },
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/registration-relawan',
    name: 'Registration Relawan',
    component: RegistrationRelawan
  },
  {
    path: '/registration-pemilih',
    name: 'Registration Pemilih',
    component: RegistrationPemilih
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
    meta: { requiresAuth: true, roles: ['relawan', 'admin'], status:'inactive' }

  },
  {
    path: '/completion-pemilih',
    name: 'Completion Pemilih',
    component: CompletionPemilih,
    meta: { requiresAuth: true, roles: ['pemilih', 'admin'], status:'inactive' }
  },
  {
    path: '/profile-pemilih',
    name: 'Profile',
    component: ProfilePemilih,
    meta: { requiresAuth: true, roles: ['pemilih'], status:'active' }
  },
  {
    path: '/profile-relawan',
    name: 'Profile',
    component: ProfileRelawan,
    meta: { requiresAuth: true, roles: ['relawan'], status:'active' }
  },
  {
    path: '/profile-admin',
    name: 'Profile',
    component: ProfileAdmin,
    meta: { requiresAuth: true, roles: ['admin'], status:'active' }
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
let previousAccessibleRoute = "";

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
});

router.beforeEach((to, from, next) => {
  const token = store.getters.isLoggedIn;
  const user = store.getters.userLogin;
  const useStatus = user.status;

  if (token && isTokenExpired()) {
    store.dispatch('setDialog', {
      isShowDialog: true,
        title: 'Perhatian',
        details: 'Sesi habis, silahkan login kembali',
        color: "orange darken-2"
    });
    store.dispatch('logout');
   setTimeout(() => {
     next({ path: '/login', replace: true });
   }, 1000);
  }

  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!token) {
      next({ path: '/login', replace: true });
    } else {
      const roles = to.meta.roles;
      const statusMeta = to.meta.status;
       if (roles && roles.length > 0) {
        if (user && roles.includes(user.role)) {
          previousAccessibleRoute = to.path; // Store accessible route 
          next();
        } else {
          store.dispatch('setDialog', {
            isShowDialog: true,
              title: 'Perhatian',
              details: 'Anda tidak memiliki akses di halaman ini, silahkan hubungi admin.',
              color: "red darken-2"
          });
          if (previousAccessibleRoute && previousAccessibleRoute !== to.path) {
            next({ path: previousAccessibleRoute, replace: true });
          } else {
            next(false);
          }

        }
      } else {
        next();
      }
    }
  } else {
    if (to.path === '/login' && token) {
      next({ path: '/', replace: true });
    } else {
      next();
    }
  }
});

export default router
