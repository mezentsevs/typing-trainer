import '../css/app.css';
import App from '@/App.vue';
import axios from 'axios';
import router from '@/router';
import theme from '@/plugins/theme';
import { applyBearer, retrieveToken } from '@/helpers/TokenHelper';
import { createApp } from 'vue';
import { createPinia } from 'pinia';

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
