<template>
    <textarea
        ref="area"
        v-model="model"
        class="p-2 border border-opacity-50 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded shadow-sm"
    />
</template>

<script lang="ts" setup>
import { Ref, ref } from 'vue';
import { UIKitTextAreaModelType } from '@/types/UIKitTypes';

const model = defineModel<UIKitTextAreaModelType>();

const area: Ref<HTMLTextAreaElement | null> = ref(null);

defineExpose({
    area,
});
</script>
