const state = () => ({
  isLoggedIn: !!localStorage.getItem('token'), // Cek token dari localStorage
  username: !!localStorage.getItem('username'), // Cek token dari localStorage
});

const mutations = {
  SET_LOGGED_IN(state, status) {
    state.isLoggedIn = status;
  },
  SET_USERNAME(state, username) {
    state.username  = username;
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
    localStorage.removeItem('token');
    localStorage.removeItem('username');
    commit('SET_LOGGED_IN', false);
    commit('SET_USERNAME', '');

  },
};

const getters = {
  isLoggedIn: (state) => state.isLoggedIn,
  username: (state) => state.username,
};

export default {
  state,
  mutations,
  actions,
  getters,
};
