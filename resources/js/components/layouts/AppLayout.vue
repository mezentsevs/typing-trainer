<template>
    <BaseLayout class="min-h-screen flex items-center justify-center">
        <ThemeToggle />
        <slot />
    </BaseLayout>
</template>

<script lang="ts" setup>
import BaseLayout from '@/components/layouts/BaseLayout.vue';
import ThemeToggle from '@/components/uikit/ThemeToggle.vue';
</script>
