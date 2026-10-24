import '../css/app.css';
import axios from 'axios';
import { createApp } from 'vue';
import { createPinia } from 'pinia';

import { applyBearer, purgeToken, retrieveToken } from '@/helpers/TokenHelper';
import App from '@/App.vue';
import router from '@/router/Router';
import theme from '@/plugins/Theme';

axios.defaults.baseURL = '/api';
axios.interceptors.response.use(
    response => response,
    error => {
        if (axios.isAxiosError(error) && error.response?.status === 401 && retrieveToken()) {
            purgeToken();
            router.push('/login');
        }

        return Promise.reject(error);
    },
);
applyBearer(retrieveToken());

createApp(App)
    .directive('focus', {
        mounted: (el: HTMLElement): void => el.focus(),
    })
    .use(createPinia())
    .use(router)
    .use(theme)
    .mount('#app');
