<template>
    <BaseButton :type class="bg-blue-500 dark:bg-gray-200">
        <slot />
    </BaseButton>
</template>

<script lang="ts" setup>
import { Button } from '@/enums/UIKitEnums';
import BaseButton from '@/components/uikit/buttons/BaseButton.vue';

withDefaults(
    defineProps<{
        type?: Button;
    }>(),
    {
        type: Button.Submit,
    },
);
</script>
