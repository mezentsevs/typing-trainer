import {
    NavigationGuardNext,
    NavigationGuardReturn,
    RouteLocationNormalized,
    RouteLocationNormalizedLoaded,
    RouteRecordRaw,
    Router,
    _Awaitable,
    createRouter,
    createWebHistory,
} from 'vue-router';

import { APP_NAME } from '@/consts/AppConsts';
import FinalTest from '@/pages/FinalTest.vue';
import Home from '@/pages/Home.vue';
import Lesson from '@/pages/Lesson.vue';
import LessonSetup from '@/pages/LessonSetup.vue';
import Login from '@/pages/auth/Login.vue';
import Register from '@/pages/auth/Register.vue';

const routes: RouteRecordRaw[] = [
    { path: '/', component: Home, meta: { requiresAuth: true, title: 'Home' } },
    { path: '/login', component: Login, meta: { title: 'Login' } },
    { path: '/register', component: Register, meta: { title: 'Register' } },
    {
        path: '/setup',
        component: LessonSetup,
        meta: { requiresAuth: true, title: 'Setup Lessons' },
    },
    {
        path: '/lesson/:language/:number',
        component: Lesson,
        meta: { requiresAuth: true, title: 'Lesson' },
    },
    {
        path: '/test/:language',
        component: FinalTest,
        meta: { requiresAuth: true, title: 'Final Test' },
    },
];

const router: Router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(
    (
        to: RouteLocationNormalized,
        from: RouteLocationNormalizedLoaded,
        next: NavigationGuardNext,
    ): _Awaitable<NavigationGuardReturn> => {
        const token: string | null = localStorage.getItem('token');

        if (to.meta.requiresAuth && !token) {
            next('/login');
        } else {
            next();
        }

        document.title = to.meta.title ? `${to.meta.title} - ${APP_NAME}` : APP_NAME;
    },
);

export default router;
