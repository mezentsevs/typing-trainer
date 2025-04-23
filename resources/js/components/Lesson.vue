<template>
    <div class="min-h-screen bg-gray-100 p-8">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow-md">
            <div class="relative flex items-center mb-4">
                <h2 class="text-2xl font-bold">Lesson {{ lesson.number }}</h2>
                <span v-if="isLessonCompleted" class="absolute left-1/2 transform -translate-x-1/2 text-green-600 text-3xl font-bold">Completed!</span>
            </div>
            <NewCharacters :new-chars="lesson.new_chars" />
            <Statistics :language="language" :time="time" :speed="speed" :errors="errors" :progress="progress" />
            <div class="mt-4">
                <div class="text-lg font-mono">
                    <span v-for="(char, index) in text" :key="index" :class="{ 'error-char': typed[index] && typed[index] !== char }">
                        {{ char }}
                    </span>
                </div>
                <input
                    v-model="typed"
                    @input="handleInput"
                    class="w-full p-2 border rounded mt-4"
                    ref="input"
                    autofocus
                    :disabled="isLessonCompleted"
                />
                <VirtualKeyboard :language="language as 'en' | 'ru'" :typed="typed" :text="text" />
            </div>
            <router-link
                v-if="nextLesson && isLessonCompleted"
                :to="`/lesson/${language}/${nextLesson.number}`"
                @click="resetAndLoadNext"
                class="mt-4 inline-block bg-blue-500 text-white p-2 rounded"
            >
                Next Lesson
            </router-link>
            <router-link
                v-else-if="isLessonCompleted"
                :to="`/test/${language}`"
                class="mt-4 inline-block bg-green-500 text-white p-2 rounded"
            >
                Take Final Test
            </router-link>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref, computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import VirtualKeyboard from './VirtualKeyboard.vue';
import Statistics from './Statistics.vue';
import NewCharacters from './NewCharacters.vue';

const route = useRoute();
const language = route.params.language as string;
const lessonNumber = ref(parseInt(route.params.number as string));
const lesson = ref<{ id: number; number: number; new_chars: string }>({ id: 0, number: lessonNumber.value, new_chars: '' });
const text = ref('');
const typed = ref('');
const startTime = ref(0);
const time = ref(0);
const errors = ref(0);
const speed = ref(0);
const input = ref<HTMLInputElement | null>(null);
const lessons = ref<any[]>([]);
const isLessonCompleted = ref(false);

const nextLesson = computed(() => lessons.value.find(l => l.number === lessonNumber.value + 1));
const progress = computed(() => text.value.length ? Math.round((typed.value.length / text.value.length) * 100) : 0);

const resetState = () => {
    text.value = '';
    typed.value = '';
    startTime.value = 0;
    time.value = 0;
    errors.value = 0;
    speed.value = 0;
    isLessonCompleted.value = false;
};

const fetchLesson = async () => {
    const [lessonsRes, textRes] = await Promise.all([
        axios.get(`/lessons/${language}`),
        axios.get(`/lessons/${language}/${lessonNumber.value}/text`),
    ]);

    lessons.value = lessonsRes.data;
    lesson.value = lessonsRes.data.find((l: any) => l.number === lessonNumber.value);
    text.value = textRes.data.text;
};

const handleInput = async () => {
    if (!startTime.value) {
        startTime.value = Date.now();
    }

    if (typed.value.length >= text.value.length) {
        typed.value = typed.value.slice(0, text.value.length);
        isLessonCompleted.value = true;
        await axios.post('/lessons/progress', {
            lesson_id: lesson.value.id,
            language: language,
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

const resetAndLoadNext = async () => {
    if (!isLessonCompleted.value) return;
    lessonNumber.value++;
    resetState();
    await fetchLesson();
    if (input.value) {
        input.value.focus();
    }
};

onMounted(async () => {
    resetState();
    await fetchLesson();
    if (input.value) {
        input.value.focus();
    }
});
</script>
