// Main dashboard component (Sidemenu,Headermenu etc.)
import Dashboard from '@/components/dashboard/Index'

// Admin components
import Home from '@/components/dashboard/Home.vue'
import AdminManageUsers from '@/components/dashboard/admin/ManageUsers'
import Products from '@/components/dashboard/admin/Products'
import Catalog from '@/components/dashboard/admin/Catalog'

import SalesCatalogs from '@/components/dashboard/sales/ProductCatalog'
import SalesProducts from '@/components/dashboard/sales/ProductOrder'

import ArtistProducts from '@/components/dashboard/artist/ProductOrder'

const routes = [
    { 
        path: '/home', 
        component: Dashboard,
        meta: {
            requiresAuth: true
        }, 
        children: [
            {
                path: '',
                name: 'home',
                component: Home,
                meta: {
                    metaTitle: 'Home',
                    redirectTo: 'login',
                }
            },{
                path: 'manage-users',
                name: 'admin-manage-users',
                component: AdminManageUsers,
                meta: {
                    metaTitle: 'Manage Users',
                    role: 'Admin',
                }
            },{
                path: 'catalog',
                name: 'admin-catalogs',
                component: Catalog,
                meta: {
                    metaTitle: 'Catalog',
                    role: 'Admin',
                }
            },{
                path: 'products',
                name: 'admin-products',
                component: Products,
                meta: {
                    metaTitle: 'Products',
                    role: 'Admin',
                }
            },{
                path: 'sales-catalog',
                name: 'sales-catalogs',
                component: SalesCatalogs,
                meta: {
                    metaTitle: 'Catalog',
                    role: 'Sales',
                }
            },{
                path: 'sales-products',
                name: 'sales-products',
                component: SalesProducts,
                meta: {
                    metaTitle: 'Products',
                    role: 'Sales',
                }
            },{
                path: 'artist-products',
                name: 'artist-products',
                component: ArtistProducts,
                meta: {
                    metaTitle: 'Products',
                    role: 'Artist',
                }
            }
        ]
    }
]

export default routes