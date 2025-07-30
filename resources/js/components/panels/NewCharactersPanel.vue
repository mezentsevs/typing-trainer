<template>
    <section
        class="p-4 flex flex-col items-center justify-center border border-opacity-50 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 text-center select-none rounded-lg shadow-sm">
        <div class="font-bold text-sm break-all">{{ newChars }}</div>
        <div class="text-xs opacity-50">New Characters</div>
    </section>
</template>

<script lang="ts" setup>
defineProps<{
    newChars: string;
}>();
</script>
