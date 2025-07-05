<template>
    <section class="p-4 border border-opacity-50 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg">
        <div class="flex justify-between">
            <StatisticsItem v-for="item in items" :key="item.name">
                <template #name>{{ item.name }}</template>
                {{ item.value }}
            </StatisticsItem>
        </div>
        <ProgressBar :progress />
    </section>
</template>

<script lang="ts" setup>
import ProgressBar from '@/components/uikit/ProgressBar.vue';
import StatisticsItem from '@/components/StatisticsItem.vue';
import { computed, ComputedRef } from 'vue';
import { formatTime } from '@/helpers/DateTimeHelper';

const props = defineProps<{
    language: string,
    time: number,
    speed: number,
    errors: number,
    progress: number,
}>();

const items: ComputedRef<Record<string, string | number>[]> = computed(() => [
    { name: 'Language', value: props.language },
    { name: 'Time', value: formatTime(props.time) },
    { name: 'Speed', value: `${props.speed} WPM` },
    { name: 'Errors', value: props.errors },
]);
</script>
