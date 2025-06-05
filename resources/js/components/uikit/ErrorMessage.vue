<template>
    <BaseMessage v-if="message" class="text-red-500">
        {{ message }}
    </BaseMessage>
</template>

<script lang="ts" setup>
import BaseMessage from '@/components/uikit/BaseMessage.vue';

defineProps<{
    message: string;
}>();
</script>
