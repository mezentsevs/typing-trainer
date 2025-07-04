<template>
    <AuthCard>
        <template #logo>
            <!--Logo-->
        </template>

        <Heading :level="2" class="text-2xl mb-6">Register</Heading>
        <form @submit.prevent="register">
            <InputLabel for="name" value="Name" />
            <Input
                id="name"
                v-model="form.name"
                v-focus
                class="mb-4 w-full"
                required
                autocomplete="on"
            />
            <InputLabel for="email" value="Email" />
            <Input
                id="email"
                v-model="form.email"
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
            <InputLabel for="passwordConfirmation" value="Confirm Password" />
            <Input
                id="passwordConfirmation"
                v-model="form.passwordConfirmation"
                type="password"
                class="mb-4 w-full"
                required
            />
            <PrimaryButton class="w-full">Register</PrimaryButton>
        </form>
        <ErrorMessage :message="error" />
        <p class="mt-4">
            Already have an account? <PrimaryRouterLink to="/login">Login</PrimaryRouterLink>
        </p>
    </AuthCard>
</template>

<script lang="ts" setup>
import AuthActions from '@/interfaces/auth/AuthActions';
import AuthCard from '@/components/cards/AuthCard.vue';
import AuthGetters from '@/interfaces/auth/AuthGetters';
import AuthRegisterForm from '@/interfaces/auth/AuthRegisterForm';
import AuthState from '@/interfaces/auth/AuthState';
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

const authStore: Store<string, AuthState, AuthGetters, AuthActions> = useAuthStore();
const router: Router = useRouter();

const error: Ref<string> = ref('');
const form: Ref<AuthRegisterForm> = ref({ name: '', email: '', password: '', passwordConfirmation: '' });

const register = async (): Promise<void> => {
    try {
        await authStore.register(
            form.value.name,
            form.value.email,
            form.value.password,
            form.value.passwordConfirmation,
        );

        await router.push('/');
    } catch (err) {
        if (err instanceof Error) { error.value = 'Registration failed'; }
    }
};
</script>
