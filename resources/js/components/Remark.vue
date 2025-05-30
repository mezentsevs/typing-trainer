<template>
    <span v-if="text" class="opacity-50">({{ text }})</span>
</template>

<script lang="ts" setup>
import { defineProps } from 'vue';

defineProps<{
    text: string;
}>();
</script>
