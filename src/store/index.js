import Vue from 'vue'
import Vuex from 'vuex'
import employees from './modules/employee'
import settings from './modules/settings'
import breadcrumbs from './modules/breadcrumbs'
import inboxs from './modules/inbox'
import trackings from './modules/tracking'
import access from './modules/access'
import unit from './modules/unit'
import lookup from './modules/lookup'
import unknown from './modules/unknown'
import historys from './modules/history'
import auth from './modules/auth'; // Import modul auth
// import dialog from './modules/dialog'; // Import modul auth

Vue.use(Vuex)
export default new Vuex.Store({
  modules: {
    auth,
    employees,
    settings,
    breadcrumbs,
    inboxs,
    trackings,
    access,
    unit,
    lookup,
    unknown,
    historys
  }
});