<template>
    <div class="mt-4 w-full">
        <div class="w-full bg-gray-200 rounded-full h-4 relative">
            <div
                class="h-4 rounded-full transition-all duration-300"
                :style="{
                    width: `${progress}%`,
                    backgroundColor: `rgb(${255 - (progress / 100) * (255 - 34)}, ${255 - (progress / 100) * (255 - 197)}, ${255 - (progress / 100) * (255 - 94)})`
                }"
            ></div>
            <p class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-xs font-bold">{{ progress }}%</p>
        </div>
    </div>
</template>

<script lang="ts" setup>
defineProps<{
    progress: number;
}>();
</script>
