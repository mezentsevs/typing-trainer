<template>
    <div
        class="min-h-screen grow bg-gradient-to-br from-blue-100 via-white to-purple-50 dark:from-gray-900 dark:via-blue-950 dark:to-purple-950 text-center flex flex-col items-center justify-center">
        <h1
            class="pb-2 text-5xl md:text-7xl font-mono text-transparent bg-clip-text bg-gradient-to-r from-blue-700 to-purple-950 dark:from-cyan-400 dark:to-purple-500">
            <span>{{ currentText }}</span>
            <span
                class="typing-cursor inline-block h-[1em] border-solid border-r-[0.05em] border-r-[currentColor] text-blue-700 dark:text-cyan-400" />
        </h1>
        <p
            class="mt-8 text-lg md:text-xl text-gray-700 dark:text-gray-300 font-sans animate-pulse-slow">
            {{ APP_SLOGAN }}
        </p>
        <div class="mt-12 flex flex-col items-center gap-6">
            <router-link to="/setup" :class="[COMMON_BUTTON_CLASS, START_BUTTON_CLASS]">
                Start
            </router-link>
            <button :class="[COMMON_BUTTON_CLASS, LOGOUT_BUTTON_CLASS]" @click="logout">
                Logout
            </button>
        </div>
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div
                v-for="(circle, index) in CIRCLES"
                :key="index"
                class="absolute rounded-full animate-float opacity-20 dark:opacity-10"
                :class="circle.class" />
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
import { useAuthStore } from '@/stores/Auth';

const authStore: Store<string, AuthState, AuthGetters, AuthActions> = useAuthStore();
const router: Router = useRouter();

const CIRCLES: Record<string, string>[] = [
    { class: 'top-10 left-10 w-24 h-24 bg-blue-300/70 dark:bg-cyan-500' },
    { class: 'bottom-20 right-20 w-32 h-32 bg-fuchsia-300/70 dark:bg-purple-500 delay-1000' },
    { class: 'top-1/2 left-1/4 w-16 h-16 bg-rose-300/70 dark:bg-red-500 delay-500' },
];

const COMMON_BUTTON_CLASS: string =
    'w-48 py-2 px-4 bg-transparent border-2 text-lg font-mono transition-all duration-200 ease-in-out text-center rounded-lg';
const LOGOUT_BUTTON_CLASS: string =
    'border-rose-500 text-rose-500 hover:bg-rose-500/5 active:bg-rose-500/10 dark:border-red-500 dark:text-red-400 dark:hover:bg-red-500/10 dark:shadow-[0_0_10px_0_rgba(239,68,68,0.5)] dark:hover:shadow-[0_0_15px_0_rgba(239,68,68,0.7)] dark:active:bg-red-500/20';
const START_BUTTON_CLASS: string =
    'border-blue-500 text-blue-500 hover:bg-blue-500/5 active:bg-blue-500/10 dark:border-cyan-500 dark:text-cyan-400 dark:hover:bg-cyan-500/10 dark:shadow-[0_0_10px_0_rgba(6,182,212,0.5)] dark:hover:shadow-[0_0_15px_0_rgba(6,182,212,0.7)] dark:active:bg-cyan-500/20';

const currentText: Ref<string> = ref('');

const logout = async (): Promise<void> => {
    await authStore.logout();
    await router.push('/login');
};

const runTypingAnimation = (): void => {
    let i: number = 0;

    const interval: NodeJS.Timeout = setInterval((): void => {
        if (i < APP_NAME.length) {
            currentText.value += APP_NAME[i];
            i++;
        } else {
            clearInterval(interval);

            setTimeout((): void => {
                currentText.value = '';

                runTypingAnimation();
            }, 2000);
        }
    }, 100);
};

onMounted((): void => {
    runTypingAnimation();
});
</script>

<style scoped>
.typing-cursor {
    animation: blink-typing-cursor 0.75s step-end infinite;
}

@keyframes blink-typing-cursor {
    from,
    to {
        border-color: transparent;
    }
    50% {
        border-color: currentColor;
    }
}

.animate-pulse-slow {
    animation: pulse 6s ease-in-out infinite;
}

@keyframes pulse {
    0%,
    100% {
        opacity: 0.7;
    }
    50% {
        opacity: 1;
    }
}

.animate-float {
    animation: float 8s ease-in-out infinite;
}

@keyframes float {
    0% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-20px);
    }
    100% {
        transform: translateY(0);
    }
}

.delay-500 {
    animation-delay: 0.5s;
}

.delay-1000 {
    animation-delay: 1s;
}
</style>
