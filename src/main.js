import Vue from 'vue';
import AxiosPlugin from 'vue-axios-cors';
import axios from "axios";
import App from './App.vue';
import router from './router';
import store from './store';
import vuetify from './plugins/vuetify';
import httpClientAxios from './auth/http-common';
import VuePapaParse from 'vue-papa-parse';
import mixins from 'vuetify-multiple-draggable-dialogs';
import VuetifyLib from 'vuetify/lib';
import 'vuetify/dist/vuetify.min.css';
 
import {
  hmrDirtyComponents
} from '@vue/runtime-dom';

Vue.config.productionTip = false;
Vue.mixin(mixins);

new Vue({
  axios,
  router,
  store,
  vuetify,
  VuetifyLib,
  httpClientAxios,
  AxiosPlugin,
  VuePapaParse,
  render: h => h(App)
}).$mount('#app');

// Clear the code cache on hot module reload
if (
  import.meta.hot) {
  import.meta.hot.accept()
  import.meta.hot.dispose(() => {
    // Before the reload, mark all dirty components as reloaded
    app._container.__vueApp__.unmount()
    hmrDirtyComponents.forEach((component) => {
      component.__hmrUpdated = true
    })
  })
}