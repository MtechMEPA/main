// store/dialog.js
export const state = () => ({
  dialogState: {
    dialogData: {
      isShowDialog: false,
      data: {
        title: '',
        details: ''
      }
    }
  }
});

export const mutations = {
  updateDialogData(state, dialogData) {
    state.dialogState.dialogData = dialogData;
  }
};

export const actions = {
  updateDialog({ commit }, dialogData) {
    commit('updateDialogData', dialogData);
  }
};

export const getters = {
  dialogData: (state) => state.dialogState.dialogData,
  isShowDialog: (state) => state.dialogState.dialogData.isShowDialog
};


export default {
  state,
  mutations,
  actions,
  getters,
};
