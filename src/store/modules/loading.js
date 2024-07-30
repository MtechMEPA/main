export const state = {
    OverlayLoading: false,
  };
  
  export const mutations = {
    SHOW_OVERLAY_LOADING(state) {
      state.OverlayLoading = true;
    },
    HIDE_OVERLAY_LOADING(state) {
      state.OverlayLoading = false;
    },
  };
  
  export const actions = {
    showOverlayLoading({ commit }) {
      commit('SHOW_OVERLAY_LOADING');
    },
    hideOverlayLoading({ commit }) {
      commit('HIDE_OVERLAY_LOADING');
    },
  };
  
  export const getters = {
    isOverlayLoading: state => state.OverlayLoading,
  };

  export default {
    state,
    mutations,
    actions,
    getters,
  };
  