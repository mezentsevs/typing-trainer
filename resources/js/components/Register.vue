<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6">Register</h2>
            <form @submit.prevent="register">
                <div class="mb-4">
                    <label class="block text-gray-700">Name</label>
                    <input v-model="form.name" type="text" class="w-full p-2 border rounded" required />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Email</label>
                    <input v-model="form.email" type="email" class="w-full p-2 border rounded" required />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Password</label>
                    <input v-model="form.password" type="password" class="w-full p-2 border rounded" required />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Confirm Password</label>
                    <input v-model="form.password_confirmation" type="password" class="w-full p-2 border rounded" required />
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Register</button>
            </form>
            <p class="mt-4">
                Already have an account? <router-link to="/login" class="text-blue-500">Login</router-link>
            </p>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

const authStore = useAuthStore();
const router = useRouter();
const form = ref({ name: '', email: '', password: '', password_confirmation: '' });

const register = async () => {
    try {
        await authStore.register(form.value.name, form.value.email, form.value.password, form.value.password_confirmation);
        router.push('/');
    } catch (error) {
        alert('Registration failed');
    }
};
</script>
