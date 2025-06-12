<template>
    <div class="w-1/2 mx-auto my-4 border border-opacity-50 rounded-lg p-4">
        <div class="text-center">
            <p class="font-bold text-sm break-all">{{ newChars }}</p>
            <p class="text-xs opacity-50">New Characters</p>
        </div>
    </div>
</template>

<script lang="ts" setup>
defineProps<{
    newChars: string,
}>();
</script>
