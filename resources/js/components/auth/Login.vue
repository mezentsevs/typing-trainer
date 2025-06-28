<template>
    <AuthLayout>
        <AuthCard>
            <template #logo>
                <!--Logo-->
            </template>

            <Heading :level="2" class="text-2xl mb-6">Login</Heading>
            <form @submit.prevent="login">
                <InputLabel for="email" value="Email" />
                <Input
                    id="email"
                    v-model="form.email"
                    v-focus
                    type="email"
                    class="mb-4 w-full"
                    required
                    autocomplete="on"
                />
                <InputLabel for="password" value="Password" />
                <Input
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mb-4 w-full"
                    required
                />
                <PrimaryButton class="w-full">Login</PrimaryButton>
            </form>
            <ErrorMessage :message="error" />
            <p class="mt-4">
                Don't have an account? <PrimaryRouterLink to="/register">Register</PrimaryRouterLink>
            </p>
        </AuthCard>
    </AuthLayout>
</template>

<script lang="ts" setup>
import AuthActionsInterface from '@/interfaces/auth/AuthActionsInterface';
import AuthCard from '@/components/auth/AuthCard.vue';
import AuthGettersInterface from '@/interfaces/auth/AuthGettersInterface';
import AuthLayout from '@/layouts/AuthLayout.vue';
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
    } catch (err) {
        if (err instanceof Error) { error.value = 'Login failed'; }
    }
};
</script>
