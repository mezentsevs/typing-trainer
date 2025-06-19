<template>
    <textarea
        ref="area"
        v-model="model"
        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded shadow-sm"
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
