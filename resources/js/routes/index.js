import authRoutes from './modules/auth-routes'
import dashboardRoutes from './modules/dashboard-routes'

var allRoutes = []
allRoutes = allRoutes.concat(authRoutes, dashboardRoutes)

export const routes = allRoutes
