<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6">Login</h2>
            <form @submit.prevent="login">
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input id="email" v-model="form.email" type="email" class="w-full p-2 border rounded" required autocomplete="on" />
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input id="password" v-model="form.password" type="password" class="w-full p-2 border rounded" required />
                </div>
                <PrimaryButton class="w-full">Login</PrimaryButton>
            </form>
            <ErrorMessage :message="error" />
            <p class="mt-4">
                Don't have an account? <router-link to="/register" class="text-blue-500">Register</router-link>
            </p>
        </div>
    </div>
</template>

<script lang="ts" setup>
import AuthActionsInterface from '@/interfaces/auth/AuthActionsInterface';
import AuthGettersInterface from '@/interfaces/auth/AuthGettersInterface';
import AuthStateInterface from '@/interfaces/auth/AuthStateInterface';
import ErrorMessage from './ErrorMessage.vue';
import LoginFormInterface from '@/interfaces/auth/LoginFormInterface';
import PrimaryButton from '@/components/uikit/PrimaryButton.vue';
import { Ref, ref } from 'vue';
import { Router, useRouter } from 'vue-router';
import { Store } from 'pinia';
import { useAuthStore } from '@/stores/auth';

const authStore: Store<string, AuthStateInterface, AuthGettersInterface, AuthActionsInterface> = useAuthStore();
const router: Router = useRouter();

const error: Ref<string> = ref('');
const form: Ref<LoginFormInterface> = ref({ email: '', password: '' });

const login = async (): Promise<void> => {
    try {
        await authStore.login(
            form.value.email,
            form.value.password,
        );

        await router.push('/');
    } catch (err: any) {
        error.value = 'Login failed';
    }
};
</script>
