<template>
    <div class="w-1/2 mx-auto my-4 border border-opacity-50 rounded-lg p-4">
        <div class="mb-4">
            <label for="genre" class="block text-gray-700">Genre <Remark text="optional" /></label>
            <select id="genre" v-model="genre" class="p-2 border rounded w-full">
                <option value="">None</option>
                <option value="fiction">Fiction</option>
                <option value="non-fiction">Non-fiction</option>
                <option value="poetry">Poetry</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="file" class="block text-gray-700">Text <Remark text="optional, max 3 KB" /></label>
            <input id="file" type="file" accept=".txt" @change="uploadFile" class="p-2 border rounded w-full" />
        </div>
        <PrimaryButton @click="$emit('start', genre)" class="w-full">Start</PrimaryButton>
        <ErrorMessage :message="error" />
    </div>
</template>

<script lang="ts" setup>
import ErrorMessage from '@/components/uikit/ErrorMessage.vue';
import PrimaryButton from '@/components/uikit/PrimaryButton.vue';
import Remark from '@/components/Remark.vue';
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
