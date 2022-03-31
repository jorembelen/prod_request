import Error404 from '@/components/error/404'

// Auth components
import Auth from '@/components/auth/Index'
    import Login from '@/components/auth/Login'

const routes = [
    // Auth Routes
    { 
        path: '/',
        component: Auth,
        meta: { 
            shouldHaveNoAuth: true 
        },
        children: [
            {   
                path: '', 
                name: 'login', 
                component: Login, 
                meta: { 
                    metaTitle: 'Welcome To Our System',
                    redirectTo: 'home' 
                }
            }
        ]
    },
    // Error 404 Route
    { path: '*', name:'404', component: Error404 }
]

export default routes