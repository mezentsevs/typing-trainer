<template>
    <div class="w-1/2 mx-auto my-4 border border-opacity-50 rounded-lg p-4">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold">Genre (optional)</label>
            <select v-model="genre" class="p-2 border rounded w-full text-sm">
                <option value="">None</option>
                <option value="fiction">Fiction</option>
                <option value="non-fiction">Non-fiction</option>
                <option value="poetry">Poetry</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold">Upload Text (optional)</label>
            <input type="file" accept=".txt" @change="uploadFile" class="p-2 border rounded w-full text-sm" />
        </div>
        <button @click="$emit('start-test', genre)" class="bg-blue-500 text-white p-2 rounded w-full text-sm">Start Test</button>
    </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue';

const genre = ref('');
defineProps<{
    uploadFile: (event: Event) => void;
}>();
defineEmits<{
    (e: 'start-test', genre: string): void;
}>();
</script>
