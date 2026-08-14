<template>
    <textarea
        ref="area"
        :value="model"
        class="custom-scroll-textarea p-2 border border-opacity-50 border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-lg shadow-sm transition-[box-shadow] duration-150"
        @input="onInput"
        @paste.prevent
        @cut.prevent
        @drop.prevent
        @click="moveCursorToEnd"
        @mouseup="moveCursorToEnd"
        @keyup="moveCursorToEnd" />
</template>

<script lang="ts" setup>
import { Ref, ref } from 'vue';
import { UIKitTextAreaModel } from '@/types/UIKitTypes';

const model = defineModel<UIKitTextAreaModel>();

const area: Ref<HTMLTextAreaElement | null> = ref(null);

const isValidChange = (oldValue: string, newValue: string): boolean => {
    if (newValue.length === oldValue.length + 1) {
        return newValue.startsWith(oldValue);
    }

    if (newValue.length === oldValue.length - 1) {
        return oldValue.startsWith(newValue);
    }

    return false;
};

const onInput = (event: Event): void => {
    const target = event.target as HTMLTextAreaElement;
    const newValue = target.value;
    const oldValue = model.value ?? '';

    if (isValidChange(oldValue, newValue)) {
        model.value = newValue;
    } else {
        target.value = oldValue;
    }

    moveCursorToEnd();
};

const moveCursorToEnd = (): void => {
    if (!area.value) {
        return;
    }

    const length = area.value.value.length;
    area.value.setSelectionRange(length, length);
};

defineExpose({
    area,
});
</script>
