<template>
    <section class="p-4 flex flex-col items-center justify-center border border-opacity-50 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 text-center rounded-lg">
        <p class="font-bold text-sm break-all">{{ newChars }}</p>
        <p class="text-xs opacity-50">New Characters</p>
    </section>
</template>

<script lang="ts" setup>
defineProps<{
    newChars: string,
}>();
</script>
