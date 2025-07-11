<template>
    <button
        @click="toggleTheme"
        class="p-2 fixed top-4 right-4 bg-gray-200 dark:bg-gray-800 rounded-full z-50"
    >
        <LightThemeIcon v-if="isDark" class="w-6 h-6 text-gray-200" />
        <DarkThemeIcon v-else class="w-6 h-6 text-gray-800" />
    </button>
</template>

<script lang="ts" setup>
import DarkThemeIcon from '@/components/icons/theme/DarkThemeIcon.vue';
import LightThemeIcon from '@/components/icons/theme/LightThemeIcon.vue';
import Theme from '@/interfaces/app/Theme';
import { inject, Ref } from 'vue';

const theme: Theme | undefined = inject('theme');
const isDark: Ref<boolean> | undefined = theme?.isDark;
const toggleTheme: (() => void) | undefined = theme?.toggleTheme;
</script>
