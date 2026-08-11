<template>
    <BaseMessage v-if="message" class="text-gray-500 dark:text-gray-400">
        {{ message }}
    </BaseMessage>
</template>

<script lang="ts" setup>
import BaseMessage from '@/components/uikit/messages/BaseMessage.vue';

defineProps<{
    message: string;
}>();
</script>
