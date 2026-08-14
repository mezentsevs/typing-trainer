<template>
    <button
        :type
        class="w-48 px-4 py-2 border-2 rounded-lg bg-transparent text-lg font-mono text-center transition-all duration-200 ease-in-out"
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
        return 'border-rose-500 text-rose-500 hover:bg-rose-500/5 active:bg-rose-500/10 dark:border-red-500 dark:text-red-400 dark:hover:bg-red-500/10 dark:shadow-[0_0_10px_0_rgba(239,68,68,0.5)] dark:hover:shadow-[0_0_15px_0_rgba(239,68,68,0.7)] dark:active:bg-red-500/20';
    }

    return 'border-blue-500 text-blue-500 hover:bg-blue-500/5 active:bg-blue-500/10 dark:border-cyan-500 dark:text-cyan-400 dark:hover:bg-cyan-500/10 dark:shadow-[0_0_10px_0_rgba(6,182,212,0.5)] dark:hover:shadow-[0_0_15px_0_rgba(6,182,212,0.7)] dark:active:bg-cyan-500/20';
});

const onClick = (): void => {
    emit('click');
};
</script>
