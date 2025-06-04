<template>
    <BaseRouterLink :to class="bg-green-500 dark:bg-gray-200">
        <slot />
    </BaseRouterLink>
</template>

<script lang="ts" setup>
import BaseRouterLink from '@/components/uikit/BaseRouterLink.vue';
import { UIKitRouterLinkToType } from '@/types/UIKitTypes';

withDefaults(defineProps<{
    to?: UIKitRouterLinkToType,
}>(), {
    to: '/',
});
</script>
