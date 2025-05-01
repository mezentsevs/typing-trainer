<template>
    <div class="min-h-screen bg-gray-100 p-8">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow-md">
            <div class="relative flex items-center mb-4">
                <h2 class="text-2xl font-bold">Final Test</h2>
                <span v-if="isTestCompleted"
                      class="absolute left-1/2 transform -translate-x-1/2 text-green-500 text-3xl font-bold"
                >
                    Completed!
                </span>
            </div>
            <FinalTestSetup v-if="!text" :upload-file="uploadFile" @start-test="fetchText" />
            <Statistics v-if="text" :language :time :speed :errors :progress />
            <div v-if="text" class="mt-4">
                <div ref="textContainer" class="text-lg font-mono break-words whitespace-pre-wrap h-28 overflow-y-auto bg-gray-50 p-2">
                    <span v-for="(char, index) in text"
                          :key="index"
                          :class="{ 'error-char': typed[index] && typed[index] !== char, 'current-word': isCurrentWord[index], 'space': char === ' ', 'line-break': char === '\n' }"
                    >
                        {{ char }}
                    </span>
                </div>
                <textarea
                    v-model="typed"
                    @input="handleInput"
                    class="w-full p-2 border rounded mt-4 resize-none"
                    ref="input"
                    :disabled="isTestCompleted"
                    autofocus
                    rows="4"
                />
                <VirtualKeyboard :language="language as 'en' | 'ru'" :typed :text />
                <div v-if="isTestCompleted" class="flex justify-center mt-2">
                    <router-link to="/" class="bg-blue-500 text-white p-2 rounded">Back to Home</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import FinalTestSetup from './FinalTestSetup.vue';
import Statistics from './Statistics.vue';
import VirtualKeyboard from './VirtualKeyboard.vue';
import axios from 'axios';
import { getCurrentTypingUnit } from '@/helpers/StringHelper';
import { ref, computed, onMounted } from 'vue';
import { scrollToCurrentChar } from '@/helpers/DomHelper';
import { useRoute } from 'vue-router';

const route = useRoute();

const errors = ref(0);
const genre = ref('');
const input = ref<HTMLTextAreaElement | null>(null);
const isTestCompleted = ref(false);
const language = ref(route.params.language as string);
const speed = ref(0);
const startTime = ref(0);
const text = ref('');
const textContainer = ref<HTMLElement | null>(null);
const time = ref(0);
const typed = ref('');

const currentTypingUnit = computed(() => getCurrentTypingUnit(text.value, typed.value.length));

const isCurrentWord = computed(() => {
    const range = currentTypingUnit.value;
    const arr = Array(text.value.length).fill(false);

    if (!range) { return arr; }

    for (let i = range.start; i <= range.end; i++) { arr[i] = true; }

    return arr;
});

const progress = computed(() => text.value.length ? Math.round((typed.value.length / text.value.length) * 100) : 0);

const fetchText = async (selectedGenre: string) => {
    genre.value = selectedGenre;

    const response = await axios.get('/test/text', { params: { language: language.value, genre: genre.value } });

    text.value = response.data.text;

    errors.value = 0;
    isTestCompleted.value = false;
    speed.value = 0;
    startTime.value = 0;
    time.value = 0;
    typed.value = '';
};

const uploadFile = async (event: Event) => {
    const file = (event.target as HTMLInputElement).files?.[0];

    if (file) {
        const formData = new FormData();

        formData.append('file', file);
        formData.append('language', language.value);

        await axios.post('/test/upload', formData);
        await fetchText(genre.value);
    }
};

//TODO: move duplications in Lesson.vue and FinalTest.vue to helper if possible
const handleInput = async () => {
    if (!startTime.value) { startTime.value = Date.now(); }

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
        if (typedChars[i] !== text.value[i]) { errorCount++; }
    }

    errors.value = errorCount;

    time.value = Math.round((Date.now() - startTime.value) / 1000);
    const words = typed.value.length / 5;
    speed.value = time.value > 0 ? Math.round((words / time.value) * 60) : 0;

    scrollToCurrentChar(textContainer.value, typed.value.length);
};

//TODO: fix input autofocus
onMounted(() => {
    if (input.value) { input.value.focus(); }
});
</script>
