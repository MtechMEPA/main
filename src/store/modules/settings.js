import { useBreakpoints } from './useBreakpoints'

const state = () => {
  const { width, type, cleanup } = useBreakpoints()

  return {
    color: "cyan darken-2",
    isMobileData: null,
    isDarkMode: false,
    outlinedGeneralButton: true,
    defaultImageContentHeight: "300",
    defaultImageContentWidth: "300",
    defaultImageSmallContentHeight: "120",
    allCategory: "semua-kategori",
    image: {
      darkmode: "logoDark.png",
      lightmode: "logoLight.png"
    },
    menu: [
      { name: "Home", path: "/", icon: "mdi-home-roof" },
      { name: "Transactions", path: "/inboxs", icon: "mdi-phone" },
      { name: "Inbox", path: "/inbox", icon: "mdi-phone" },
      { name: "Outbox", path: "/outbox", icon: "mdi-phone" },
      { name: "Report", path: "/report", icon: "mdi-phone" }
    ],
    dialogData: {
      isShowDialog: false,
      isScroll: false,
      isPersistent: false,
      width: 600,
      title: "GKI Lahai-Roi Ayamaru",
      buttonFooter: { save: "OK", close: "OK" },
      modalType: { isGalery: false, isSearch: false },
      data: null
    },
    screenSize: {
      width,
      type
    },
    users: {
      data: 0
    },
    lookupData: {}
  }
}

const mutations = {
  settings(state, settings) {
    state.settings = settings;
  }
}

const actions = {
  settings({ commit }, settings) {
    commit('settings', settings);
  }
}

const getters = {
  settings: (state) => state.settings,
  screenSize: (state) => state.screenSize
}

export default {
  state,
  mutations,
  actions,
  getters
}
