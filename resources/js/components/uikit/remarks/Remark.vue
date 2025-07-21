<template>
    <span v-if="value" class="opacity-50">{{ value }}</span>
    <span v-else class="opacity-50"><slot /></span>
</template>

<script lang="ts" setup>
defineProps<{
    value?: string,
}>();
</script>
