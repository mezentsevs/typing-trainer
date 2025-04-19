<template>
    <div class="min-h-screen bg-gray-100 p-8">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow-md">
            <h2 class="text-2xl font-bold mb-4">Final Typing Test</h2>
            <div class="mb-4">
                <label class="block text-gray-700">Genre (optional)</label>
                <select v-model="genre" class="p-2 border rounded">
                    <option value="">None</option>
                    <option value="fiction">Fiction</option>
                    <option value="non-fiction">Non-fiction</option>
                    <option value="poetry">Poetry</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Upload Text (optional)</label>
                <input type="file" accept=".txt" @change="uploadFile" class="p-2 border rounded" />
            </div>
            <button @click="fetchText" class="bg-blue-500 text-white p-2 rounded mb-4">Start Test</button>
            <p><strong>Time:</strong> {{ time }}s</p>
            <p><strong>Speed:</strong> {{ speed }} WPM</p>
            <p><strong>Errors:</strong> {{ errors }}</p>
            <div v-if="text" class="mt-4">
                <div class="text-lg font-mono">
                    <span v-for="(char, index) in text" :key="index" :class="{ 'error-char': typed[index] && typed[index] !== char }">
                        {{ char }}
                    </span>
                </div>
                <input v-model="typed" @input="handleInput" class="w-full p-2 border rounded mt-4" ref="input" :disabled="isTestCompleted" autofocus />
                <p v-if="isTestCompleted" class="text-green-500 font-bold mt-2">Test completed!</p>
                <router-link v-if="isTestCompleted" to="/" class="bg-blue-500 text-white p-2 rounded mt-2 inline-block">Back to Home</router-link>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const language = ref(route.params.language as string);
const genre = ref('');
const text = ref('');
const typed = ref('');
const startTime = ref(0);
const time = ref(0);
const errors = ref(0);
const speed = ref(0);
const input = ref<HTMLInputElement | null>(null);
const isTestCompleted = ref(false);

const fetchText = async () => {
    const response = await axios.get('/test/text', { params: { language: language.value, genre: genre.value } });
    text.value = response.data.text;
    typed.value = '';
    startTime.value = 0;
    time.value = 0;
    errors.value = 0;
    speed.value = 0;
    isTestCompleted.value = false;
};

const uploadFile = async (event: Event) => {
    const file = (event.target as HTMLInputElement).files?.[0];
    if (file) {
        const formData = new FormData();
        formData.append('file', file);
        formData.append('language', language.value);
        await axios.post('/test/upload', formData);
        fetchText();
    }
};

const handleInput = async () => {
    if (!startTime.value) {
        startTime.value = Date.now();
    }

    const typedChars = typed.value.split('');
    let errorCount = 0;
    for (let i = 0; i < typedChars.length; i++) {
        if (typedChars[i] !== text.value[i]) {
            errorCount++;
        }
    }
    errors.value = errorCount;

    time.value = Math.round((Date.now() - startTime.value) / 1000);
    const words = typed.value.length / 5;
    speed.value = time.value > 0 ? Math.round((words / time.value) * 60) : 0;

    if (typed.value.length === text.value.length) {
        await axios.post('/test/result', {
            language: language.value,
            speed_wpm: speed.value,
            errors: errors.value,
        });
        isTestCompleted.value = true;
    }
};

onMounted(() => {
    if (input.value) {
        input.value.focus();
    }
});
</script>
