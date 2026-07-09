<template>
    <div
        class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 z-10 invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-opacity duration-200">
        <div
            class="px-2 py-1 text-xs bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 rounded shadow-lg whitespace-nowrap text-center">
            {{ text }}
        </div>
        <div
            class="absolute top-full left-1/2 -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-t-4 border-l-transparent border-r-transparent border-t-gray-800 dark:border-t-gray-200" />
    </div>
</template>

<script lang="ts" setup>
defineProps<{
    text: string;
}>();
</script>
