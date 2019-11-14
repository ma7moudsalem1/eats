import Vue from 'vue'
import Vuex from 'vuex'
import {user} from './modules/user'
import {core} from './modules/core'

Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {
      user,
      core
    },
})

export default store
