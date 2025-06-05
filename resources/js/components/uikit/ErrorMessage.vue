<template>
    <p v-if="message" class="mt-4 text-red-500">{{ message }}</p>
</template>

<script lang="ts" setup>
defineProps<{
    message: string;
}>();
</script>
