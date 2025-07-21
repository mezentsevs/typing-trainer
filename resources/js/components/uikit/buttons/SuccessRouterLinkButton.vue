<template>
    <BaseRouterLinkButton :to class="bg-green-500 dark:bg-gray-200">
        <slot />
    </BaseRouterLinkButton>
</template>

<script lang="ts" setup>
import BaseRouterLinkButton from '@/components/uikit/buttons/BaseRouterLinkButton.vue';
import { UIKitRouterLinkTo } from '@/types/UIKitTypes';

withDefaults(defineProps<{
    to?: UIKitRouterLinkTo,
}>(), {
    to: '/',
});
</script>
