<template>
    <select
        v-model="model"
        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
        :options
    >
        <option
            v-for="option in options"
            :key="option.value"
            :value="option.value"
        >
            {{ option.label }}
        </option>
    </select>
</template>

<script lang="ts" setup>
import UIKitSelectOptionInterface from '@/interfaces/uikit/UIKitSelectOptionInterface';

const model = defineModel<string | number | null>();

defineProps<{
    options: UIKitSelectOptionInterface[];
}>();
</script>
