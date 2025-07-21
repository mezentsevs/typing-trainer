<template>
    <BaseLayout class="min-h-screen flex items-center justify-center">
        <ThemeToggle />
        <slot />
    </BaseLayout>
</template>

<script lang="ts" setup>
import BaseLayout from '@/layouts/BaseLayout.vue';
import ThemeToggle from '@/components/uikit/toggles/ThemeToggle.vue';
</script>
