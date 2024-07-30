// store/modules/auth.js

const state = () => ({
  isLoggedIn: !!localStorage.getItem('token'), // Cek token dari localStorage
  username: localStorage.getItem('username') || '', // Cek username dari localStorage
  userData: JSON.parse(localStorage.getItem('userData')) || [], // Cek userData dari localStorage
  userLogin: JSON.parse(localStorage.getItem('userLogin')) || [], // Cek userData dari localStorage

});

const mutations = {
  SET_LOGGED_IN(state, status) {
    state.isLoggedIn = status;
  },
  SET_USERNAME(state, username) {
    state.username = username;
  },
  SET_USER_DATA(state, users) {
    state.userData = users;
  },
  SET_USER_LOGIN(state, userLogin) {
    state.userLogin = userLogin;
  },
  SHOW_DIALOG(state, dialogDetails) {
    state.dialogDetails = dialogDetails;
  },
};

const actions = {
  login({ commit }, { token, username }) {
    localStorage.setItem('token', token);
    localStorage.setItem('username', username);
    commit('SET_LOGGED_IN', true);
    commit('SET_USERNAME', username);
  },
  logout({ commit }) {
    localStorage.clear();
    // localStorage.removeItem('username');
    // localStorage.removeItem('userDetails');
    commit('SET_LOGGED_IN', false);
    commit('SET_USERNAME', '');
    commit('SET_USER_DATA', []);
    commit('SET_USER_LOGIN', []);
  },
  showDialog({ commit }, dialogDetails) {
    commit('SHOW_DIALOG', dialogDetails);
  },
  setUserData({ commit }, { users }) {
    localStorage.setItem('userData', JSON.stringify(users));
     commit('SET_USER_DATA', users);
   },
  setUserLogin({ commit }, {  userLogin }) {
     localStorage.setItem('userLogin', JSON.stringify(userLogin));
     commit('SET_USER_LOGIN', userLogin);
  }
};

const getters = {
  isLoggedIn: (state) => state.isLoggedIn,
  username: (state) => state.username,
  userData: (state) => state.userData,
  userLogin: (state) => state.userLogin,
};

export default {
  state,
  mutations,
  actions,
  getters,
};
