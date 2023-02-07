import { createStore } from 'vuex'
import createPersistedState from "vuex-persistedstate";
import VuexPersistence from 'vuex-persist'

export default createStore({
  state: {
    app: {
      name : 'Test Queo'
    },
    login: false,
    token: '',
    userId : '',
    sessionData : ''
  },
  getters: {
    onGetLogin: (state) => {
      return state.login
    },
    onGetToken: (state) => {
      return state.token
    },
    onGetUserId: (state) => {
      return state.userId
    },
    onGetSessionData: (state) => {
      return state.sessionData
    }
  },
  mutations: {
    SETLOGIN: (state, value) => {
      state.login = value
    },
    SETTOKEN: (state, value) => {
      state.token = value
    },
    SETUSERID: (state, value) => {
      state.userId = value
    },
    SETSESSIONDATA: (state, value) => {
      state.sessionData = value
    }
  },
  actions: {
    onSetLogin({commit}, value) {
      commit('SETLOGIN', value)
    },
    onSetToken({commit}, value) {
      commit('SETTOKEN', value)
    },
    onSetUserId({commit}, value) {
      commit('SETUSERID', value)
    },
    onSetSessionData({commit}, value) {
      commit('SETSESSIONDATA', value)
    }
  },
  plugins: [createPersistedState(),
    new VuexPersistence({
      storage: window.localStorage
    }).plugin
  ]
})
