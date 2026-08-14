<template>
    <BaseButton
        :type
        class="relative inline-flex items-center justify-center bg-blue-500 dark:bg-gray-200"
        :disabled="loading">
        <span class="text" :class="{ invisible: loading }">
            <slot />
        </span>
        <span v-if="loading" class="spinner absolute inset-0 flex items-center justify-center">
            <SpinnerIcon class="w-auto h-[1em] animate-spin" />
        </span>
    </BaseButton>
</template>

<script lang="ts" setup>
import { Button } from '@/enums/UIKitEnums';
import BaseButton from '@/components/uikit/buttons/BaseButton.vue';
import SpinnerIcon from '@/components/icons/SpinnerIcon.vue';

withDefaults(
    defineProps<{
        type?: Button;
        loading?: boolean;
    }>(),
    {
        type: Button.Submit,
        loading: false,
    },
);
</script>
