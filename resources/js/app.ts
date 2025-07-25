import '../css/app.css';
import axios from 'axios';
import { createApp } from 'vue';
import { createPinia } from 'pinia';

import App from '@/App.vue';
import router from '@/router/Router';
import theme from '@/plugins/Theme';
import { applyBearer, retrieveToken } from '@/helpers/TokenHelper';

axios.defaults.baseURL = '/api';
applyBearer(retrieveToken());

createApp(App)
    .directive('focus', {
        mounted: (el: HTMLElement): void => el.focus(),
    })
    .use(createPinia())
    .use(router)
    .use(theme)
    .mount('#app');
