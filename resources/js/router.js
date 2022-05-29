import { createRouter, createWebHistory } from 'vue-router'
import visitorLayout from './app/layout/visitor'
import adminLayout from './app/layout/admin'
import Dashboard from './app/admin/dashboard.vue'

const routes = [
    {
        path : '/',
        name : 'dashboard',
        component : Dashboard,
        meta : { layout : adminLayout, auth : true }
    }
]

var router = createRouter({
    history : createWebHistory(process.env.APP_URL),
    routes
})

export default router