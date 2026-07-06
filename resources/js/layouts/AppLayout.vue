<template>
    <BaseLayout class="min-h-screen flex items-center justify-center">
        <div class="fixed top-4 right-4 z-50 flex items-center gap-2">
            <UserBadge v-if="userName" :name="userName" />
            <ThemeToggle />
        </div>
        <slot />
    </BaseLayout>
</template>

<script lang="ts" setup>
import { computed, ComputedRef } from 'vue';
import { Store } from 'pinia';
import { useAuthStore } from '@/stores/Auth';
import AuthActions from '@/interfaces/auth/AuthActions';
import AuthGetters from '@/interfaces/auth/AuthGetters';
import AuthState from '@/interfaces/auth/AuthState';
import BaseLayout from '@/layouts/BaseLayout.vue';
import ThemeToggle from '@/components/uikit/toggles/ThemeToggle.vue';
import UserBadge from '@/components/uikit/badges/UserBadge.vue';

const authStore: Store<string, AuthState, AuthGetters, AuthActions> = useAuthStore();

const userName: ComputedRef<string> = computed((): string => authStore.user?.name ?? '');
</script>
