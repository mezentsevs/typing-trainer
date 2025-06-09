<template>
    <input
        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
        :value="modelValue"
        @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
    >
</template>

<script lang="ts" setup>
defineProps<{
    modelValue: string,
}>();

defineEmits(['update:modelValue']);
</script>
