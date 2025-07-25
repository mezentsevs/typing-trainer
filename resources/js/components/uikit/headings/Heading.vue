<template>
    <component :is="heading" class="font-bold text-gray-800 dark:text-gray-200 truncate">
        <slot />
    </component>
</template>

<script lang="ts" setup>
import { computed, ComputedRef } from 'vue';

const props = withDefaults(
    defineProps<{
        level?: number;
    }>(),
    {
        level: 1,
    },
);

const heading: ComputedRef<string> = computed((): string => {
    if (props.level < 1) {
        return 'h1';
    } else if (props.level > 6) {
        return 'h6';
    } else {
        return `h${props.level}`;
    }
});
</script>
