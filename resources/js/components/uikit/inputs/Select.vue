<template>
    <select
        v-model="model"
        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm"
        :options>
        <option v-for="option in options" :key="option.value" :value="option.value">
            {{ option.label }}
        </option>
    </select>
</template>

<script lang="ts" setup>
import UIKitSelectOption from '@/interfaces/uikit/UIKitSelectOption';
import { UIKitSelectModel } from '@/types/UIKitTypes';

const model = defineModel<UIKitSelectModel>();

defineProps<{
    options: UIKitSelectOption[];
}>();
</script>
