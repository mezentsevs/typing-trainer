<template>
    <router-link
        :to
        class="underline text-sm hover:text-gray-700 dark:hover:text-gray-100 active:text-gray-900 dark:active:text-gray-300 transition ease-in-out duration-150"
    >
        <slot />
    </router-link>
</template>

<script lang="ts" setup>
import { UIKitRouterLinkTo } from '@/types/UIKitTypes';

defineProps<{
    to: UIKitRouterLinkTo;
}>();
</script>
