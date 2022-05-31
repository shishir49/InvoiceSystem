require('./bootstrap');

import { createApp } from 'vue'
import Router from './router'
import Store from './store'
import App from './app/mainapp.vue'
import VueSweetalert2 from 'vue-sweetalert2';
import VueHtmlToPaper from './vueHtmlToPage';
import Options from './printerOptions';

createApp(App).use(VueHtmlToPaper, Options).use(VueSweetalert2).use(Store).use(Router).mount('#app')