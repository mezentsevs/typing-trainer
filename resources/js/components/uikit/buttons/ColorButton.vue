<template>
    <button
        :type
        class="w-48 px-4 py-2 border-2 rounded-lg text-white dark:bg-transparent text-lg text-center transition-all duration-200 ease-in-out"
        :class="variantClass"
        @click="onClick">
        <slot />
    </button>
</template>

<script lang="ts" setup>
import { Button, ColorButtonVariant } from '@/enums/UIKitEnums';
import { computed, ComputedRef } from 'vue';

const props = withDefaults(
    defineProps<{
        type?: Button;
        variant?: ColorButtonVariant;
    }>(),
    {
        type: Button.Button,
        variant: ColorButtonVariant.Primary,
    },
);

const emit = defineEmits<{
    (e: 'click'): void;
}>();

const variantClass: ComputedRef<string> = computed((): string => {
    if (props.variant === ColorButtonVariant.Danger) {
        return 'border-red-600 bg-red-500 hover:bg-red-600 active:bg-red-700 dark:border-red-500 dark:text-red-400 dark:hover:bg-red-500/10 dark:active:bg-red-500/20 dark:shadow-[0_0_10px_0_rgba(239,68,68,0.5)] dark:hover:shadow-[0_0_15px_0_rgba(239,68,68,0.7)]';
    }

    return 'border-blue-600 bg-blue-500 hover:bg-blue-600 active:bg-blue-700 dark:border-cyan-500 dark:text-cyan-400 dark:hover:bg-cyan-500/10 dark:active:bg-cyan-500/20 dark:shadow-[0_0_10px_0_rgba(6,182,212,0.5)] dark:hover:shadow-[0_0_15px_0_rgba(6,182,212,0.7)]';
});

const onClick = (): void => {
    emit('click');
};
</script>
