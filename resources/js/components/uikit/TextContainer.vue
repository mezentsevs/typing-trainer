<template>
    <section ref="container" class="border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 dark:text-gray-300 overflow-y-auto break-words whitespace-pre-wrap rounded shadow-sm">
        <slot />
    </section>
</template>

<script lang="ts" setup>
import { Ref, ref } from 'vue';

const container: Ref<HTMLElement | null> = ref(null);

const getContainerElement = () => container.value;

defineExpose({
    getContainerElement,
});
</script>
