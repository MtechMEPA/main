// store/dialog.js
export const state = () => ({
  dialogData: { 
      isShowDialog: false, 
      title: '',
      details: '',
      color: '' 
 
  }
});

export const mutations = {
  updateDialogData(state, dialogData) {
    state.dialogData = dialogData;
  }
};

export const actions = {
  setDialog({ commit }, dialogData) {
    commit('updateDialogData', dialogData);
  }
};

export const getters = {
  dialogData: (state) => state.dialogData,
  isShowDialog: (state) => state.dialogData.isShowDialog
};


export default {
  state,
  mutations,
  actions,
  getters,
};
