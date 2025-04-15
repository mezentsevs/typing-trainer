import { createRouter, createWebHistory } from 'vue-router';
import Home from '@/components/Home.vue';
import Login from '@/components/Login.vue';
import Register from '@/components/Register.vue';
import LessonSetup from '@/components/LessonSetup.vue';
import Lesson from '@/components/Lesson.vue';
import FinalTest from '@/components/FinalTest.vue';

const routes = [
    { path: '/', component: Home, meta: { requiresAuth: true } },
    { path: '/login', component: Login },
    { path: '/register', component: Register },
    { path: '/setup', component: LessonSetup, meta: { requiresAuth: true } },
    { path: '/lesson/:language/:number', component: Lesson, meta: { requiresAuth: true } },
    { path: '/test', component: FinalTest, meta: { requiresAuth: true } },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token');
    if (to.meta.requiresAuth && !token) {
        next('/login');
    } else {
        next();
    }
});

export default router;
