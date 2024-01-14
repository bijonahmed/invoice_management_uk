import './bootstrap';
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueSweetalert2 from 'vue-sweetalert2';
 
import 'sweetalert2/dist/sweetalert2.min.css';

import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'


import {
    createApp
} from 'vue';
import router from './router';
import App from './layouts/app.vue';
import store from './store';
import Sidebar from './components/Sidebar.vue';
import Footer from './components/Footer.vue';
import Nav from './components/Nav.vue';
createApp(App)
    .component("Sidebar", Sidebar)
    .component("Nav", Nav)
    .component("Footer", Footer)
    .component("Datepicker", Datepicker)
    .use(router)
    .use(store)
    .use(VueSweetalert2)
    .use(VueAxios, axios)
    .mount('#app');