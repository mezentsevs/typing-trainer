<template>
    <BaseButton :type class="bg-blue-500 dark:bg-gray-200">
        <slot />
    </BaseButton>
</template>

<script lang="ts" setup>
import BaseButton from '@/components/uikit/buttons/BaseButton.vue';
import { Button } from '@/enums/UIKitEnums';
import { UIKitButton } from '@/types/UIKitTypes';

withDefaults(
    defineProps<{
        type?: UIKitButton;
    }>(),
    {
        type: Button.Submit,
    },
);
</script>
