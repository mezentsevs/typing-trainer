<template>
    <div class="bg-gray-200 rounded-full overflow-hidden relative">
        <div class="h-full transition-all duration-300" :style />
        <span class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-xs font-bold dark:text-black">
            {{ progress }}%
        </span>
    </div>
</template>

<script lang="ts" setup>
import { computed, ComputedRef } from 'vue';

const props = defineProps<{
    progress: number,
}>();

const style: ComputedRef<Record<string, string>> = computed((): Record<string, string> => ({
    width: `${props.progress}%`,
    backgroundColor: `rgb(${255 - (props.progress / 100) * (255 - 34)}, ${255 - (props.progress / 100) * (255 - 197)}, ${255 - (props.progress / 100) * (255 - 94)})`,
}));
</script>
