<template>
    <div class="flex items-center gap-0.5 max-w-[160px]">
        <UserIcon class="w-4 h-4 shrink-0 text-gray-500 dark:text-gray-400" />
        <span class="truncate text-sm text-gray-700 dark:text-gray-300">
            {{ name }}
        </span>
    </div>
</template>

<script lang="ts" setup>
import UserIcon from '@/components/icons/UserIcon.vue';

defineProps<{
    name: string;
}>();
</script>
