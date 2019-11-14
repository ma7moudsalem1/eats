import store from '../store/index'
export default class lsSync {
  static syncData () {
    const userName = localStorage.getItem('first_name')
    const userId   = localStorage.getItem('client')
    const token    = localStorage.getItem('token')
    const lastName = localStorage.getItem('last_name')
    const email = localStorage.getItem('email')
    const mobile = localStorage.getItem('mobile')
    const spec    = localStorage.getItem('spec')
    const specializaion    = localStorage.getItem('specialization')
    if  (userName && userId && token && lastName) {
      store.dispatch('setUserId', userId)
      store.dispatch('setUserToken', token)
      store.dispatch('setUserName', userName)
      store.dispatch('setLastName', lastName)
      store.dispatch('setMobile', mobile)
      store.dispatch('setEmail', email)


    }
    if(spec){
      store.dispatch('setSpName', spec)
    }
    if(specializaion){
      store.dispatch('setSpecialization', specializaion)
    }
  }
}