<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6">Register</h2>
            <form @submit.prevent="register">
                <div class="mb-4">
                    <InputLabel for="name" value="Name" />
                    <Input
                        id="name"
                        v-model="form.name"
                        v-focus
                        class="w-full"
                        required
                        autocomplete="on"
                    />
                </div>
                <div class="mb-4">
                    <InputLabel for="email" value="Email" />
                    <Input
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="w-full"
                        required
                        autocomplete="on"
                    />
                </div>
                <div class="mb-4">
                    <InputLabel for="password" value="Password" />
                    <Input
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="w-full"
                        required
                    />
                </div>
                <div class="mb-4">
                    <InputLabel for="passwordConfirmation" value="Confirm Password" />
                    <Input
                        id="passwordConfirmation"
                        v-model="form.passwordConfirmation"
                        type="password"
                        class="w-full"
                        required
                    />
                </div>
                <PrimaryButton class="w-full">Register</PrimaryButton>
            </form>
            <ErrorMessage :message="error" />
            <p class="mt-4">
                Already have an account? <router-link to="/login" class="text-blue-500">Login</router-link>
            </p>
        </div>
    </div>
</template>

<script lang="ts" setup>
import AuthActionsInterface from '@/interfaces/auth/AuthActionsInterface';
import AuthGettersInterface from '@/interfaces/auth/AuthGettersInterface';
import AuthStateInterface from '@/interfaces/auth/AuthStateInterface';
import ErrorMessage from '@/components/uikit/ErrorMessage.vue';
import Input from '@/components/uikit/Input.vue';
import InputLabel from '@/components/uikit/InputLabel.vue';
import PrimaryButton from '@/components/uikit/PrimaryButton.vue';
import RegisterFormInterface from '@/interfaces/auth/RegisterFormInterface';
import { Ref, ref } from 'vue';
import { Router, useRouter } from 'vue-router';
import { Store } from 'pinia';
import { useAuthStore } from '@/stores/auth';

const authStore: Store<string, AuthStateInterface, AuthGettersInterface, AuthActionsInterface> = useAuthStore();
const router: Router = useRouter();

const error: Ref<string> = ref('');
const form: Ref<RegisterFormInterface> = ref({ name: '', email: '', password: '', passwordConfirmation: '' });

const register = async (): Promise<void> => {
    try {
        await authStore.register(
            form.value.name,
            form.value.email,
            form.value.password,
            form.value.passwordConfirmation,
        );

        await router.push('/');
    } catch (err: any) {
        error.value = 'Registration failed';
    }
};
</script>
