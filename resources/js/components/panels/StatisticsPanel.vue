<template>
    <section
        class="p-4 border border-opacity-50 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 select-none rounded-lg shadow-sm"
    >
        <div class="flex justify-between">
            <StatisticsPanelItem v-for="item in items" :key="item.name">
                <template #name>{{ item.name }}</template>
                {{ item.value }}
            </StatisticsPanelItem>
        </div>
        <ProgressBar :progress class="w-full h-4 mt-4" />
    </section>
</template>

<script lang="ts" setup>
import ProgressBar from '@/components/uikit/bars/ProgressBar.vue';
import StatisticsPanelItem from '@/components/panels/partials/StatisticsPanelItem.vue';
import { computed, ComputedRef } from 'vue';
import { formatTime } from '@/helpers/DateTimeHelper';

const props = defineProps<{
    language: string;
    time: number;
    speed: number;
    errors: number;
    progress: number;
}>();

const items: ComputedRef<Record<string, string | number>[]> = computed(
    (): Record<string, string | number>[] => [
        { name: 'Language', value: props.language },
        { name: 'Time', value: formatTime(props.time) },
        { name: 'Speed', value: `${props.speed} WPM` },
        { name: 'Errors', value: props.errors },
    ],
);
</script>
