require('./bootstrap');

import { createApp } from 'vue'
import Router from './router'
import Store from './store'
import App from './app/mainapp.vue'

createApp(App).use(Store).use(Router).mount('#app')