<template>
    <div class="mt-4 w-full">
        <div class="w-full bg-gray-200 rounded-full h-4 relative">
            <div class="h-4 rounded-full transition-all duration-300" :style />
            <p class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-xs font-bold">
                {{ progress }}%
            </p>
        </div>
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
