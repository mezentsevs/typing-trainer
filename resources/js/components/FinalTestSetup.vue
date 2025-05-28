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
            <label class="block text-gray-700 text-sm font-bold">Upload Text (max 3 KB, optional)</label>
            <input type="file" accept=".txt" @change="uploadFile" class="p-2 border rounded w-full text-sm" />
        </div>
        <button @click="$emit('start', genre)" class="bg-blue-500 text-white p-2 rounded w-full text-sm">
            Start
        </button>
        <ErrorMessage :message="error" />
    </div>
</template>

<script lang="ts" setup>
import ErrorMessage from '@/components/ErrorMessage.vue';
import { Ref, ref } from 'vue';

const genre: Ref<string> = ref('');

defineProps<{
    error: string;
    uploadFile: (event: Event) => Promise<void>;
}>();

defineEmits<{
    (e: 'start', genre: string): void;
}>();
</script>
