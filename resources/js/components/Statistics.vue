<template>
    <div class="flex justify-between max-w-1/2 mx-auto">
        <div class="text-center">
            <p class="font-bold">{{ language }}</p>
            <p class="text-sm opacity-50">Language</p>
        </div>
        <div class="text-center">
            <p class="font-bold">{{ time }}s</p>
            <p class="text-sm opacity-50">Time</p>
        </div>
        <div class="text-center">
            <p class="font-bold">{{ speed }} WPM</p>
            <p class="text-sm opacity-50">Speed</p>
        </div>
        <div class="text-center">
            <p class="font-bold">{{ errors }}</p>
            <p class="text-sm opacity-50">Errors</p>
        </div>
    </div>
</template>

<script lang="ts" setup>
defineProps<{
    language: string;
    time: number;
    speed: number;
    errors: number;
}>();
</script>
