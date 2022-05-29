import { createRouter, createWebHistory } from 'vue-router'
import visitorLayout from './app/layout/visitor'
import adminLayout from './app/layout/admin'
import Dashboard from './app/admin/dashboard.vue'
import Login from './app/auth/login.vue'
import Registration from './app/auth/registration.vue'

const routes = [
    {
        path : '/dashboard',
        name : 'dashboard',
        component : Dashboard,
        meta : { layout : adminLayout, auth : true }
    },
    {
        path : '/login',
        name : 'login',
        component : Login,
        meta : { layout : visitorLayout, visitor : true }
    },
    {
        path : '/registration',
        name : 'registration',
        component : Registration,
        meta : { layout : visitorLayout, visitor : true }
    }
]

var router = createRouter({
    history : createWebHistory(process.env.APP_URL),
    routes
})

export default router