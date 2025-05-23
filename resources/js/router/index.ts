import FinalTest from '@/components/FinalTest.vue';
import Home from '@/components/Home.vue';
import Lesson from '@/components/Lesson.vue';
import LessonSetup from '@/components/LessonSetup.vue';
import Login from '@/components/Login.vue';
import Register from '@/components/Register.vue';
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

const routes: RouteRecordRaw[] = [
    { path: '/', component: Home, meta: { requiresAuth: true } },
    { path: '/login', component: Login },
    { path: '/register', component: Register },
    { path: '/setup', component: LessonSetup, meta: { requiresAuth: true } },
    { path: '/lesson/:language/:number', component: Lesson, meta: { requiresAuth: true } },
    { path: '/test/:language', component: FinalTest, meta: { requiresAuth: true } },
];

const router: Router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((
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
});

export default router;
