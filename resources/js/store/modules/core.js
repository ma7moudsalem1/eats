export const core = {
    state: {
        country: '',
        sp: '',
        loginDialog: false,
        specialization: '',
        departments: {},
        loader: false

    },
    mutations: {
        'SET_COUNTRY' (state , country){
            state.country = country
        },
        'SET_SP_NAME' (state , sp){
            state.sp = sp
        },
        'SET_LOGIN_DIALOG' (state , loginDialog){
            state.loginDialog = loginDialog
        },
        'SET_SPECCIALIZATION' (state , specialization){
            state.specialization = specialization
        },
        'SET_DEPARTMENTS' (state , departments){
            state.departments = departments
        },
        'SET_LOADER' (state , loader){
            state.loader = loader
        },
    },
    actions: {
        setCountry({commit},country){
            commit('SET_COUNTRY',country)
        },
        setSpName({commit},spName){
            commit('SET_SP_NAME',spName)
        },
        setLoginDialog({commit},loginDialog){
            commit('SET_LOGIN_DIALOG',loginDialog)
        },
        setSpecialization({commit},specialization){
            commit('SET_SPECCIALIZATION',specialization)
        },
        setDepartments({commit},departments){
            commit('SET_DEPARTMENTS',departments)
        },
        setLoader({commit}, loader){
            commit('SET_LOADER', loader)
        }
    }
}
