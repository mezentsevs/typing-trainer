<template>
    <div class="relative w-full" :class="attrsClass">
        <input
            ref="inputRef"
            v-model="model"
            v-bind="inputAttrs"
            class="w-full pl-8 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm" />
        <div
            class="absolute top-1/2 -translate-y-1/2 left-2 w-4 h-4 text-gray-400 dark:text-gray-500">
            <slot />
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref, onMounted, useAttrs, computed } from 'vue';
import { UIKitInputModel } from '@/types/UIKitTypes';

defineOptions({ inheritAttrs: false });

const props = defineProps<{
    autoFocus?: boolean;
}>();

const model = defineModel<UIKitInputModel>();
const inputRef = ref<HTMLInputElement>();

const attrs = useAttrs();
const attrsClass = computed<string>((): string => (attrs.class as string) ?? '');
const inputAttrs = computed<Record<string, unknown>>((): Record<string, unknown> => {
    const { class: _, ...rest } = attrs;
    return rest;
});

onMounted((): void => {
    if (props.autoFocus) {
        inputRef.value?.focus();
    }
});
</script>
