export const user = {
  state: {
    userName: '',
    userId: '',
    userToken: '',
    lastName:'',
    mobile:'',
    email:''
  },
  mutations: {
    'SET_USER_TOKEN' (state , token){
      state.userToken = token
    },
    'SET_USER_ID' (state , id){
      state.userId = id
    },
    'SET_USER_NAME' (state , name){
      state.userName = name
    },
    'SET_LAST_NAME' (state , last_name){
      state.lastName = last_name
    },
    'SET_MOBILE' (state , mobile){
      state.mobile = mobile
    },
    'SET_EMAIL' (state , email){
      state.email = email
    }
  },
  actions: {
    setUserName({commit},name){
      commit('SET_USER_NAME',name)
    },
    setUserId({commit},id){
      commit('SET_USER_ID',id)
    },
    setUserToken({commit},token){
      commit('SET_USER_TOKEN',token)
    },
    setLastName({commit},last_name){
      commit('SET_LAST_NAME',last_name)
    },
    setMobile({commit},mobile){
      commit('SET_MOBILE',mobile)
    },
    setEmail({commit},email){
      commit('SET_EMAIL',email)
    }
  }
}
