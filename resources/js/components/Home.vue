<template>
    <div class="min-h-screen bg-gray-100 p-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold mb-6">Typing Trainer</h1>
            <button @click="logout" class="mb-4 bg-red-500 text-white p-2 rounded">Logout</button>
            <router-link to="/setup" class="bg-blue-500 text-white p-2 rounded">Start New Lesson</router-link>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

const authStore = useAuthStore();
const router = useRouter();

const logout = async () => {
    await authStore.logout();
    router.push('/login');
};
</script>
