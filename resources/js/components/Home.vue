<template>
    <div class="min-h-screen grow bg-gradient-to-br from-gray-900 via-blue-950 to-purple-950 text-center flex flex-col items-center justify-center">
        <h1 class="pb-2 text-5xl md:text-7xl font-mono text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-purple-500">
            <span>{{ currentText }}</span>
            <span class="cursor" />
        </h1>
        <p class="mt-8 text-lg md:text-xl text-gray-300 font-sans animate-pulse-slow">
            {{ APP_SLOGAN }}
        </p>
        <div class="mt-12 flex flex-col items-center gap-6">
            <router-link
                to="/setup"
                :class="[COMMON_BUTTON_CLASS, START_BUTTON_CLASS]"
            >
                Start
            </router-link>
            <button
                @click="logout"
                :class="[COMMON_BUTTON_CLASS, LOGOUT_BUTTON_CLASS]"
            >
                Logout
            </button>
        </div>
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div
                v-for="(circle, index) in CIRCLES"
                :key="index"
                class="absolute rounded-full animate-float opacity-10"
                :class="circle.class"
            />
        </div>
    </div>
</template>

<script lang="ts" setup>
import AuthActions from '@/interfaces/auth/AuthActions';
import AuthGetters from '@/interfaces/auth/AuthGetters';
import AuthState from '@/interfaces/auth/AuthState';
import { APP_NAME, APP_SLOGAN } from '@/consts/AppConsts';
import { Router, useRouter } from 'vue-router';
import { Store } from 'pinia';
import { ref, onMounted, Ref } from 'vue';
import { useAuthStore } from '@/stores/auth';

const authStore: Store<string, AuthState, AuthGetters, AuthActions> = useAuthStore();
const router: Router = useRouter();

const CIRCLES: Record<string, string>[] = [
    { class: 'top-10 left-10 w-24 h-24 bg-cyan-500' },
    { class: 'bottom-20 right-20 w-32 h-32 bg-purple-500 delay-1000' },
    { class: 'top-1/2 left-1/4 w-16 h-16 bg-red-500 delay-500' },
];
const COMMON_BUTTON_CLASS = 'w-48 py-2 px-4 bg-transparent border-2 text-lg font-mono transition-all duration-200 ease-in-out text-center rounded-lg';
const LOGOUT_BUTTON_CLASS = 'border-red-500 text-red-400 hover:text-red-300 hover:bg-red-500/10 shadow-[0_0_10px_0_rgba(239,68,68,0.5)] hover:shadow-[0_0_15px_0_rgba(239,68,68,0.7)]';
const START_BUTTON_CLASS = 'border-cyan-500 text-cyan-400 hover:text-cyan-300 hover:bg-cyan-500/10 shadow-[0_0_10px_0_rgba(6,182,212,0.5)] hover:shadow-[0_0_15px_0_rgba(6,182,212,0.7)]';
const currentText: Ref<string> = ref('');

const logout = async (): Promise<void> => {
    await authStore.logout();
    await router.push('/login');
};

const typeWriter = (): void => {
    let i: number = 0;

    const interval: NodeJS.Timeout = setInterval((): void => {
        if (i < APP_NAME.length) {
            currentText.value += APP_NAME[i];
            i++;
        } else {
            clearInterval(interval);

            setTimeout((): void => {
                currentText.value = '';

                typeWriter();
            }, 2000);
        }
    }, 100);
};

onMounted((): void => {
    typeWriter();
});
</script>

<style scoped>
.cursor {
    display: inline-block;
    height: 1em;
    border-right: 0.15em solid cyan;
    animation: blink-caret 0.75s step-end infinite;
}

@keyframes blink-caret {
    from, to { border-color: transparent; }
    50% { border-color: cyan; }
}

.animate-pulse-slow {
    animation: pulse 6s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 0.7; }
    50% { opacity: 1; }
}

.animate-float {
    animation: float 8s ease-in-out infinite;
}

@keyframes float {
    0% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
    100% { transform: translateY(0); }
}

.delay-500 {
    animation-delay: 0.5s;
}

.delay-1000 {
    animation-delay: 1s;
}
</style>
