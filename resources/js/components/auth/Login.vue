<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
            <Heading :level="2" class="text-2xl mb-6">Login</Heading>
            <form @submit.prevent="login">
                <div class="mb-4">
                    <InputLabel for="email" value="Email" />
                    <Input
                        id="email"
                        v-model="form.email"
                        v-focus
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
                <PrimaryButton class="w-full">Login</PrimaryButton>
            </form>
            <ErrorMessage :message="error" />
            <p class="mt-4">
                Don't have an account? <PrimaryRouterLink to="/register">Register</PrimaryRouterLink>
            </p>
        </div>
    </div>
</template>

<script lang="ts" setup>
import AuthActionsInterface from '@/interfaces/auth/AuthActionsInterface';
import AuthGettersInterface from '@/interfaces/auth/AuthGettersInterface';
import AuthLoginFormInterface from '@/interfaces/auth/AuthLoginFormInterface';
import AuthStateInterface from '@/interfaces/auth/AuthStateInterface';
import ErrorMessage from '@/components/uikit/ErrorMessage.vue';
import Heading from '@/components/uikit/Heading.vue';
import Input from '@/components/uikit/Input.vue';
import InputLabel from '@/components/uikit/InputLabel.vue';
import PrimaryButton from '@/components/uikit/PrimaryButton.vue';
import PrimaryRouterLink from '@/components/uikit/PrimaryRouterLink.vue';
import { Ref, ref } from 'vue';
import { Router, useRouter } from 'vue-router';
import { Store } from 'pinia';
import { useAuthStore } from '@/stores/auth';

const authStore: Store<string, AuthStateInterface, AuthGettersInterface, AuthActionsInterface> = useAuthStore();
const router: Router = useRouter();

const error: Ref<string> = ref('');
const form: Ref<AuthLoginFormInterface> = ref({ email: '', password: '' });

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
