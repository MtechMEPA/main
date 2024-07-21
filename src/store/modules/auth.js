const state = () => ({
  isLoggedIn: !!localStorage.getItem('token'), // Cek token dari localStorage
  username: localStorage.getItem('username') || '', // Cek username dari localStorage
  userDetails: JSON.parse(localStorage.getItem('userDetails')) || {}, // Cek userDetails dari localStorage
});

const mutations = {
  SET_LOGGED_IN(state, status) {
    state.isLoggedIn = status;
  },
  SET_USERNAME(state, username) {
    state.username = username;
  },
  SET_USER_DETAILS(state, userDetails) {
    state.userDetails = userDetails;
  },
};

const actions = {
  login({ commit }, { token, username, userDetails }) {
    localStorage.setItem('token', token);
    localStorage.setItem('username', username);
    localStorage.setItem('userDetails', JSON.stringify(userDetails));
    commit('SET_LOGGED_IN', true);
    commit('SET_USERNAME', username);
    commit('SET_USER_DETAILS', userDetails);
  },
  logout({ commit }) {
    localStorage.removeItem('token');
    localStorage.removeItem('username');
    localStorage.removeItem('userDetails');
    commit('SET_LOGGED_IN', false);
    commit('SET_USERNAME', '');
    commit('SET_USER_DETAILS', {});
  },
};

const getters = {
  isLoggedIn: (state) => state.isLoggedIn,
  username: (state) => state.username,
  userDetails: (state) => state.userDetails,
};

export default {
  state,
  mutations,
  actions,
  getters,
};
