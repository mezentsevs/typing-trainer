<template>
    <div class="min-h-screen bg-gray-100 p-8">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow-md">
            <h2 class="text-2xl font-bold mb-4">Lesson {{ lesson.number }} ({{ language }})</h2>
            <p><strong>New Characters:</strong> {{ lesson.new_chars }}</p>
            <p><strong>Time:</strong> {{ time }}s</p>
            <p><strong>Speed:</strong> {{ speed }} WPM</p>
            <p><strong>Errors:</strong> {{ errors }}</p>
            <div class="mt-4">
                <div class="text-lg font-mono">
                    <span v-for="(char, index) in text" :key="index" :class="{ 'error-char': typed[index] && typed[index] !== char }">
                        {{ char }}
                    </span>
                </div>
                <input v-model="typed" @input="handleInput" class="w-full p-2 border rounded mt-4" ref="input" autofocus />
            </div>
            <router-link v-if="nextLesson" :to="`/lesson/${language}/${nextLesson.number}`" class="mt-4 inline-block bg-blue-500 text-white p-2 rounded">
                Next Lesson
            </router-link>
            <router-link v-else to="/test" class="mt-4 inline-block bg-green-500 text-white p-2 rounded">
                Take Final Test
            </router-link>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref, computed, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const router = useRouter();
const language = route.params.language as string;
const lessonNumber = parseInt(route.params.number as string);
const lesson = ref<{ id: number; number: number; new_chars: string }>({id: 0, number: lessonNumber, new_chars: '' });
const text = ref('');
const typed = ref('');
const startTime = ref(0);
const time = ref(0);
const errors = ref(0);
const speed = ref(0);
const input = ref<HTMLInputElement | null>(null);
const lessons = ref<any[]>([]);

const nextLesson = computed(() => lessons.value.find(l => l.number === lessonNumber + 1));

const fetchLesson = async () => {
    const [lessonsRes, textRes, ] = await Promise.all([
        axios.get(`/lessons/${language}`),
        axios.get(`/lessons/${language}/${lessonNumber}/text`),
    ]);

    lessons.value = lessonsRes.data;
    lesson.value = lessonsRes.data.find((l: any) => l.number === lessonNumber);
    text.value = textRes.data.text;
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
        await axios.post('/lessons/progress', {
            lesson_id: lesson.value.id,
            time_seconds: time.value,
            speed_wpm: speed.value,
            errors: errors.value,
        });
        if (!nextLesson.value) {
            router.push('/test');
        }
    }
};

onMounted(() => {
    fetchLesson();
    if (input.value) {
        input.value.focus();
    }
});
</script>
