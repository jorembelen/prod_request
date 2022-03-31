
const state = {
   users: null,
   categories: null,
   catalogs: null,
   products: null
}

const getters = {
    users(state) {
        return state.users
    }, 
    categories(state) {
        return state.categories
    },
    catalogs(state) {
        return state.catalogs
    },
    products(state) {
        return state.products
    }
}

const mutations = {
    updateUsers(state, payload) {
        state.users = payload
    },
    updateCategories(state, payload) {
        state.categories = payload
    },
    updateCatalogs(state, payload) {
        state.catalogs = payload
    },
    updateProducts(state, payload) {
        state.products = payload
    }
}

const actions = {
    getUsers(context) {
        axios.get('/api/all-users')
        .then((response) => {
            context.commit('updateUsers', response.data)
        })
    },
    getCategories(context) {
        axios.get('/api/all-categories')
        .then((response) => {
            context.commit('updateCategories', response.data)
        })
    },
    getCatalogs(context) {
        axios.get('/api/all-catalogs')
        .then((response) => {
            context.commit('updateCatalogs', response.data)
        })
    },
    getProducts(context) {
        axios.get('/api/all-products')
        .then((response) => {
            context.commit('updateProducts', response.data)
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