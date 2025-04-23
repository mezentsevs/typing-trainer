<template>
    <div class="w-1/2 mx-auto">
        <div class="flex justify-between">
            <div class="w-full text-center">
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
    </div>
</template>

<script lang="ts" setup>
defineProps<{
    progress: number;
}>();
</script>
