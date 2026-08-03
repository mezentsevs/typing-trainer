<template>
    <AuthCard>
        <template #logo>
            <router-link to="/" class="mb-6">
                <LogoIcon class="w-12 h-12 text-blue-500 dark:text-blue-600" />
            </router-link>
        </template>

        <Heading :level="1" class="text-2xl mb-6">Login</Heading>
        <form @submit.prevent="login">
            <InputLabel for="email" value="Email" />
            <InputWithIcon
                id="email"
                v-model="form.email"
                auto-focus
                type="email"
                class="mb-4"
                required
                autocomplete="on">
                <EnvelopeIcon />
            </InputWithIcon>
            <InputLabel for="password" value="Password" />
            <InputWithIcon
                id="password"
                v-model="form.password"
                type="password"
                class="mb-4"
                required>
                <LockIcon />
            </InputWithIcon>
            <PrimaryButton class="w-full mt-2">Login</PrimaryButton>
        </form>
        <ErrorMessage :message="error" />
        <p class="mt-4">
            Don't have an account?
            <PrimaryRouterLink to="/register">Register</PrimaryRouterLink>
        </p>
    </AuthCard>
</template>

<script lang="ts" setup>
import { Ref, ref } from 'vue';
import { Router, useRouter } from 'vue-router';
import { Store } from 'pinia';
import { useAuthStore } from '@/stores/Auth';
import AuthActions from '@/interfaces/auth/AuthActions';
import AuthCard from '@/pages/partials/cards/AuthCard.vue';
import AuthGetters from '@/interfaces/auth/AuthGetters';
import AuthLoginForm from '@/interfaces/auth/AuthLoginForm';
import AuthState from '@/interfaces/auth/AuthState';
import EnvelopeIcon from '@/components/icons/EnvelopeIcon.vue';
import ErrorMessage from '@/components/uikit/messages/ErrorMessage.vue';
import Heading from '@/components/uikit/headings/Heading.vue';
import InputLabel from '@/components/uikit/inputs/partials/InputLabel.vue';
import InputWithIcon from '@/components/uikit/inputs/InputWithIcon.vue';
import LockIcon from '@/components/icons/LockIcon.vue';
import LogoIcon from '@/components/icons/LogoIcon.vue';
import PrimaryButton from '@/components/uikit/buttons/PrimaryButton.vue';
import PrimaryRouterLink from '@/components/uikit/links/PrimaryRouterLink.vue';

const authStore: Store<string, AuthState, AuthGetters, AuthActions> = useAuthStore();
const router: Router = useRouter();

const error: Ref<string> = ref('');
const form: Ref<AuthLoginForm> = ref({ email: '', password: '' });

const login = async (): Promise<void> => {
    try {
        await authStore.login(form.value.email, form.value.password);
        await router.push('/');
    } catch (err: any) {
        error.value = err?.response?.data?.message || 'Login failed';
    }
};
</script>
