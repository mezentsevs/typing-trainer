<template>
    <div class="w-1/2 mx-auto my-4 border border-opacity-50 rounded-lg p-4">
        <div class="flex justify-between">
            <div class="text-center">
                <p class="font-bold text-sm">{{ language }}</p>
                <p class="text-xs opacity-50">Language</p>
            </div>
            <div class="text-center">
                <p class="font-bold text-sm">{{ formattedTime }}</p>
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
        <Progress :progress="progress" />
    </div>
</template>

<script lang="ts" setup>
import Progress from '@/components/Progress.vue';
import { computed } from 'vue';
import { formatTime } from '@/helpers/DateTimeHelper';

const props = defineProps<{
    language: string;
    time: number;
    speed: number;
    errors: number;
    progress: number;
}>();

const formattedTime = computed(() => formatTime(props.time));
</script>
