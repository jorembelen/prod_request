import NProgress from 'nprogress';

export function initialize(store, router) {

    router.beforeEach((to, from, next) => {
        NProgress.start()
        // you could define your own authentication logic with token
        let isLoggedIn = store.getters['auth/isLoggedIn']
        let userRole = store.getters['auth/currentUserRole']
      
        // check route meta if it requires auth or not
        if(to.matched.some(record => record.meta.requiresAuth)) {
            if (!isLoggedIn) {
                next({
                    name: to.meta.redirectTo,
                    params: { nextUrl: to.fullPath }
                })
            } else {
                // check user role since user is authenticated and redirect to respective dashboard
                if(to.meta.role) {
                    if(userRole == to.meta.role) {
                        next()
                    } else {
                        next({path:'*'})
                    }
                } else {
                    next()
                }
                
            }
        } 
        else if(to.matched.some(record => record.meta.shouldHaveNoAuth)) {
            if (isLoggedIn) {
                next({
                    name: to.meta.redirectTo,
                })
            } else {
                next()
            }
        } 
        else {
            // check if page not exist
            if(to.name == '*') {
                next({name:'404'})
            } else {
                next()
            }
        }
    })

    router.afterEach((to, from) => {
        NProgress.done()
    })

    // axios.interceptors.response.use(null, (error)=> {
    //     if(error.response.status == 401) {
    //         store.commit('logout');
    //         router.push('/login');
    //     }
    //     return Promise.reject(error);
    // });

    axios.defaults.headers.common["Authorization"] = (store.getters['auth/currentUser'])? 'Bearer '+store.getters['auth/currentUser'].token: '';
}