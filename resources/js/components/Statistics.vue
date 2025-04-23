<template>
    <div class="w-1/2 mx-auto my-4 border border-opacity-50 rounded-lg p-4">
        <div class="flex justify-between">
            <div class="text-center">
                <p class="font-bold text-sm">{{ language }}</p>
                <p class="text-xs opacity-50">Language</p>
            </div>
            <div class="text-center">
                <p class="font-bold text-sm">{{ time }}s</p>
                <p class="text-xs opacity-50">Time</p>
            </div>
            <div class="text-center">
                <p class="font-bold text-sm">{{ speed }} WPM</p>
                <p class="text-xs opacity-50">Speed</p>
            </div>
            <div class="text-center">
                <p class="font-bold text-sm">{{ errors }}</p>
                <p class="text-xs opacity-50">Errors</p>
            </div>
        </div>
        <div class="mt-4 w-full">
            <div class="w-full bg-gray-200 rounded-full h-4 relative">
                <div
                    class="h-4 rounded-full transition-all duration-300"
                    :style="{
                        width: `${progress}%`,
                        backgroundColor: `rgb(${255 - (progress / 100) * (255 - 22)}, ${255 - (progress / 100) * (255 - 163)}, ${255 - (progress / 100) * (255 - 74)})`
                    }"
                ></div>
                <p class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-xs font-bold">{{ progress }}%</p>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
defineProps<{
    language: string;
    time: number;
    speed: number;
    errors: number;
    progress: number;
}>();
</script>
