<template>
    <BaseButton
        :type
        class="relative inline-flex items-center justify-center bg-blue-500 dark:bg-gray-200"
        :disabled="loading">
        <span class="text" :class="{ invisible: loading }">
            <slot />
        </span>
        <span v-if="loading" class="spinner absolute inset-0 flex items-center justify-center">
            <Spinner class="w-auto h-[1em] animate-spin" />
        </span>
    </BaseButton>
</template>

<script lang="ts" setup>
import { Button } from '@/enums/UIKitEnums';
import { UIKitButton } from '@/types/UIKitTypes';
import BaseButton from '@/components/uikit/buttons/BaseButton.vue';
import Spinner from '@/components/uikit/spinners/Spinner.vue';

withDefaults(
    defineProps<{
        type?: UIKitButton;
        loading?: boolean;
    }>(),
    {
        type: Button.Submit,
        loading: false,
    },
);
</script>
