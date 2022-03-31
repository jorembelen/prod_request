import { getLocalUser } from '@/helpers/auth'
import Axios from 'axios';

const user = getLocalUser()

const state = {
    currentUser: user,
    isLoggedIn: !!user,
    loading: false,
    auth_error: null,
    auth_success: null,
    auth_info: null,
    userDetails: null
}

const getters = {
    authSuccess(state) {
        return state.auth_success
    },
    authError(state) {
        return state.auth_error
    },
    authInfo(state) {
        return state.auth_info
    },
    isLoading(state) {
        return state.loading
    },
    isLoggedIn(state) {
        return state.isLoggedIn
    },
    currentUser(state) {
        return state.currentUser
    },
    currentUserSlug(state) {
        return (state.currentUser)? state.currentUser.role[0].slug : null ;
    },
    currentUserRole(state) {
        return (state.currentUser)? state.currentUser.role[0].name : null ;
    },
    userDetails(state) {
        return state.userDetails
    }
}

const mutations = {
    loading(state) {
        state.auth_error = null
        state.auth_success = null
        state.auth_info = null
        state.loading = true
    },
    clearAlerts() {
        state.auth_error = null
        state.auth_success = null
        state.auth_info = null
    },
    loginSuccess(state, payload) {
        state.auth_error = null
        state.isLoggedIn = true
        state.loading = false
        state.currentUser = Object.assign({}, payload.user, {token: payload.auth.access_token})

        localStorage.setItem('user', JSON.stringify(state.currentUser))
    },
    loginError(state, payload) {
        state.loading = false
        state.auth_error = payload.error
    },
    loginInfo(state, payload) {
        state.loading = false
        state.auth_info = payload.info
    },
    registerSuccess(state, payload) {
        state.loading = false
        state.auth_error = null
        state.auth_success = payload.success
    },
    registerError(state, payload) {
        state.loading = false
        state.auth_success = null
        state.auth_error = payload
    },
    logout(state) {
        localStorage.removeItem('user');
        state.isLoggedIn = false
        state.currentUser = null
    },
    updateUserDetails(state, payload) {
        state.userDetails = payload
    }
}

const actions = {
    loading(context) {
        context.commit('loading')
    },
    clearAlerts(context) {
        context.commit('clearAlerts')
    },
    login(context, payload) {
        context.commit('loginSuccess', payload)
    },
    logout(context) {
        axios.post('/api/logout')
        .then((response) => {
            if(response.status == 200) {
                window.location.href = '/'
                context.commit('logout');
            }
        })
        // .catch((response) => {
        //     if (response.status == undefined) {
        //         context.commit('logout');
        //     }
        // })
    },
    getUserDetails(context) {
        axios.get('/api/user')
        .then((response) => {
            // res(response.data);
            context.commit('updateUserDetails', response.data)
        })
    }
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}