<template>
    <div class="min-h-screen bg-gray-100 p-8">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow-md">
            <div class="relative flex items-center mb-4">
                <h2 class="text-2xl font-bold">Final Test</h2>
                <span v-if="isTestCompleted" class="absolute left-1/2 transform -translate-x-1/2 text-green-600 text-3xl font-bold">Completed!</span>
            </div>
            <FinalTestSetup v-if="!text" :upload-file="uploadFile" @start-test="fetchText" />
            <Statistics v-if="text" :language="language" :time="time" :speed="speed" :errors="errors" />
            <div v-if="text" class="mt-4">
                <div class="text-lg font-mono">
                    <span v-for="(char, index) in text" :key="index" :class="{ 'error-char': typed[index] && typed[index] !== char }">
                        {{ char }}
                    </span>
                </div>
                <input v-model="typed" @input="handleInput" class="w-full p-2 border rounded mt-4" ref="input" :disabled="isTestCompleted" autofocus />
                <VirtualKeyboard :language="language as 'en' | 'ru'" :typed="typed" :text="text" />
                <router-link v-if="isTestCompleted" to="/" class="bg-blue-500 text-white p-2 rounded mt-2 inline-block">Back to Home</router-link>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import VirtualKeyboard from './VirtualKeyboard.vue';
import Statistics from './Statistics.vue';
import FinalTestSetup from './FinalTestSetup.vue';

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
        await fetchText();
    }
};

const handleInput = async () => {
    if (!startTime.value) {
        startTime.value = Date.now();
    }

    if (typed.value.length >= text.value.length) {
        typed.value = typed.value.slice(0, text.value.length);
        isTestCompleted.value = true;
        await axios.post('/test/result', {
            language: language.value,
            time_seconds: time.value,
            speed_wpm: speed.value,
            errors: errors.value,
        });
        return;
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
};

onMounted(() => {
    if (input.value) {
        input.value.focus();
    }
});
</script>
