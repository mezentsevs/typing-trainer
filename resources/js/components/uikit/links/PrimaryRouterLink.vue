<template>
    <BaseRouterLink :to class="text-blue-500 dark:text-blue-600">
        <slot />
    </BaseRouterLink>
</template>

<script lang="ts" setup>
import BaseRouterLink from '@/components/uikit/links/BaseRouterLink.vue';
import { UIKitRouterLinkTo } from '@/types/UIKitTypes';

withDefaults(
    defineProps<{
        to?: UIKitRouterLinkTo;
    }>(),
    {
        to: '/',
    },
);
</script>
