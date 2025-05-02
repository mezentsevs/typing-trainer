import '../css/app.css';
import App from '@/App.vue';
import axios from 'axios';
import router from '@/router';
import { createApp } from 'vue';
import { createPinia } from 'pinia';

axios.defaults.baseURL = '/api';
const token = localStorage.getItem('token');

if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

createApp(App)
    .directive('focus', {
        mounted: (el: HTMLElement) => el.focus(),
    })
    .use(createPinia())
    .use(router)
    .mount('#app');
