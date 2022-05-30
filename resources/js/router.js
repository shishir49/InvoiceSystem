import { createRouter, createWebHistory } from 'vue-router'
import visitorLayout from './app/layout/visitor'
import adminLayout from './app/layout/admin'
import Dashboard from './app/admin/dashboard.vue'
import AddInvoice from './app/admin/invoice/add.vue'
import UpdateInvoice from './app/admin/invoice/update.vue'
import InvoiceList from './app/admin/invoice/list.vue'
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
        path : '/add-invoice',
        name : 'add-invoice',
        component : AddInvoice,
        meta : { layout : adminLayout, auth : true }
    },
    {
        path : '/update-invoice/:id',
        name : 'update-invoice',
        component : UpdateInvoice,
        meta : { layout : adminLayout, auth : true }
    },
    {
        path : '/invoice-list',
        name : 'invoice-list',
        component : InvoiceList,
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

function isLoggedIn() {
    return localStorage.getItem('token')
}

router.beforeEach((to, from, next) => {
   if(to.matched.some(record => record.meta.auth)) {
        if(!isLoggedIn()) {
            next({
                path : '/login'
            })
        }else{
            next()
        }
   }else if(to.matched.some(record => record.meta.visitor)) {
        if(isLoggedIn()) {
            next({
                path : '/dashboard'
            })
        }else{
            next()
        }
   }else{
       next()
   }
})

export default router