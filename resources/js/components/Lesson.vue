<template>
    <div class="min-h-screen bg-gray-100 p-8">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow-md">
            <div class="relative flex items-center mb-4">
                <h2 class="text-2xl font-bold">Lesson {{ lesson.number }}/{{ totalLessons }}</h2>
                <span v-if="isLessonCompleted" class="absolute left-1/2 transform -translate-x-1/2 text-green-500 text-3xl font-bold">
                    Completed!
                </span>
            </div>
            <div class="flex flex-row items-stretch space-x-4 mb-4">
                <NewCharacters :new-chars="lesson.new_chars" class="flex items-center justify-center" />
                <Statistics :language :time :speed :errors :progress />
            </div>
            <div class="mt-4">
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
                    v-focus
                    @input="handleInput"
                    class="w-full p-2 border rounded mt-4 resize-none"
                    ref="input"
                    :disabled="isLessonCompleted"
                    rows="4"
                    spellcheck="false"
                />
                <VirtualKeyboard :language="language as 'en' | 'ru'" :typed :text />
                <div v-if="isLessonCompleted" class="flex justify-center mt-4">
                    <router-link
                        v-if="nextLesson"
                        :to="`/lesson/${language}/${nextLesson}`"
                        @click="resetAndLoadNext"
                        class="bg-blue-500 text-white p-2 rounded"
                    >
                        Next Lesson
                    </router-link>
                    <router-link
                        v-else
                        :to="`/test/${language}`"
                        class="bg-green-500 text-white p-2 rounded"
                    >
                        Take Final Test
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import NewCharacters from './NewCharacters.vue';
import Statistics from './Statistics.vue';
import VirtualKeyboard from './VirtualKeyboard.vue';
import axios from 'axios';
import useTypingLogic from '@/composables/useTypingLogic';
import { getCurrentTypingUnit } from '@/helpers/StringHelper';
import { ref, computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const { handleTypingInput } = useTypingLogic();

const errors = ref(0);
const input = ref<HTMLTextAreaElement | null>(null);
const isLessonCompleted = ref(false);
const language = route.params.language as string;
const lessonNumber = ref(parseInt(route.params.number as string));
const lesson = ref<{ id: number; number: number; new_chars: string }>({ id: 0, number: lessonNumber.value, new_chars: '' });
const speed = ref(0);
const startTime = ref(0);
const text = ref('');
const textContainer = ref<HTMLElement | null>(null);
const time = ref(0);
const totalLessons = ref(0);
const typed = ref('');

const currentTypingUnit = computed(() => getCurrentTypingUnit(text.value, typed.value.length));

const isCurrentWord = computed(() => {
    const range = currentTypingUnit.value;
    const arr = Array(text.value.length).fill(false);

    if (!range) { return arr; }

    for (let i = range.start; i <= range.end; i++) { arr[i] = true; }

    return arr;
});

const nextLesson = computed(() => (totalLessons.value - lessonNumber.value) ? lessonNumber.value + 1 : 0);

const progress = computed(() => {
    if (isLessonCompleted.value) { return 100; }

    return text.value.length ? Math.floor((typed.value.length / text.value.length) * 100) : 0;
});

const resetState = () => {
    errors.value = 0;
    isLessonCompleted.value = false;
    speed.value = 0;
    startTime.value = 0;
    text.value = '';
    time.value = 0;
    typed.value = '';
    lesson.value = { id: 0, number: lessonNumber.value, new_chars: '' };
};

const fetchLesson = async () => {
    const response = await axios.get(`/lessons/${language}/${lessonNumber.value}`);

    lesson.value = response.data.lesson;
    totalLessons.value = response.data.lesson.total;
    text.value = response.data.lesson.text;
};

const handleInput = async () => {
    await handleTypingInput(
        {
            errors,
            isCompleted: isLessonCompleted,
            language,
            speed,
            startTime,
            text,
            textContainer,
            time,
            typed,
            progress,
        },
        '/lessons/progress',
        {
            lesson_id: lesson.value.id,
            language,
            time_seconds: time.value,
            speed_wpm: speed.value,
            errors: errors.value,
        }
    );
};

const resetAndLoadNext = async () => {
    if (!isLessonCompleted.value) { return; }

    lessonNumber.value++;

    resetState();

    await fetchLesson();

    if (input.value) { input.value.focus(); }
};

onMounted(async () => {
    resetState();

    await fetchLesson();
});
</script>
