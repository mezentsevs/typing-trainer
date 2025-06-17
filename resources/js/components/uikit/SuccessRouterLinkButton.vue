<template>
    <BaseRouterLinkButton :to class="bg-green-500 dark:bg-gray-200">
        <slot />
    </BaseRouterLinkButton>
</template>

<script lang="ts" setup>
import BaseRouterLinkButton from '@/components/uikit/BaseRouterLinkButton.vue';
import { UIKitRouterLinkToType } from '@/types/UIKitTypes';

withDefaults(defineProps<{
    to?: UIKitRouterLinkToType,
}>(), {
    to: '/',
});
</script>
