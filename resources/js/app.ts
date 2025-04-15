import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from '@/App.vue';
import router from '@/router';
import axios from 'axios';
import '@/assets/tailwind.css';

axios.defaults.baseURL = '/api';
const token = localStorage.getItem('token');
if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

const app = createApp(App);
app.use(createPinia());
app.use(router);
app.mount('#app');
