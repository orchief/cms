import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)
import state from './state'
import mutations from './mutations'
import app from './app'
import getters from './getters'
import actions from './actions'
export default new Vuex.Store({
  modules: {
    app
  },
  state,
  mutations,
  getters,
  actions
})
