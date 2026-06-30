<template>
    <div class="flex items-center gap-1.5 text-xs text-gray-700 dark:text-gray-300">
        <AiIcon class="w-6 h-6 shrink-0 opacity-50" />
        <Remark>{{ text }}</Remark>
    </div>
</template>

<script lang="ts" setup>
import AiIcon from '@/components/icons/AiIcon.vue';
import Remark from '@/components/uikit/remarks/Remark.vue';

defineProps<{
    text: string;
}>();
</script>
