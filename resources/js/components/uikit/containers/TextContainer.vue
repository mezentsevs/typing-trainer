<template>
    <article
        ref="container"
        class="custom-scroll-container p-2 border border-opacity-50 border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 dark:text-gray-300 overflow-y-auto break-words whitespace-pre-wrap select-none rounded-lg shadow-sm">
        <slot />
    </article>
</template>

<script lang="ts" setup>
import { Ref, ref } from 'vue';

const container: Ref<HTMLElement | null> = ref(null);

const getContainerElement = (): HTMLElement | null => container.value;

defineExpose({
    getContainerElement,
});
</script>
