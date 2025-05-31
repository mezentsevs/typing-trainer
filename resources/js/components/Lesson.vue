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
                <NewCharacters :new-chars="lesson.newChars" class="flex items-center justify-center" />
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
                    id="typed"
                    v-model="typed"
                    v-focus
                    @input="onInput"
                    class="w-full p-2 border rounded mt-4 resize-none"
                    ref="input"
                    :disabled="isLessonCompleted"
                    rows="4"
                    spellcheck="false"
                />
                <VirtualKeyboard :language :typed :text />
                <div v-if="isLessonCompleted" class="flex justify-center mt-4">
                    <router-link
                        v-if="nextLesson"
                        :to="`/lesson/${language}/${nextLesson}`"
                        @click="onNext"
                        class="w-32 bg-blue-500 text-center text-white p-2 rounded"
                    >
                        Next
                    </router-link>
                    <router-link
                        v-else
                        :to="`/test/${language}`"
                        class="w-32 bg-green-500 text-center text-white p-2 rounded"
                    >
                        Final Test
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
import axios, { AxiosResponse } from 'axios';
import { KeyboardLanguageEnum } from '@/enums/KeyboardEnums';
import { RouteLocationNormalizedLoaded, useRoute } from 'vue-router';
import { ref, computed, onMounted, Ref, ComputedRef } from 'vue';
import { useHandleTypingInput, useCurrentWord, useProgress } from '@/composables/TypingComposables';

const route: RouteLocationNormalizedLoaded<string | symbol> = useRoute();
const { handleTypingInput }: Record<string, Function> = useHandleTypingInput();

const errors: Ref<number> = ref(0);
const input: Ref<HTMLTextAreaElement | null> = ref(null);
const isLessonCompleted: Ref<boolean> = ref(false);
const language: KeyboardLanguageEnum = route.params.language as KeyboardLanguageEnum;
const lessonNumber: Ref<number> = ref(parseInt(route.params.number as string));
const lesson: Ref<{ id: number; number: number; newChars: string }> = ref({ id: 0, number: lessonNumber.value, newChars: '' });
const speed: Ref<number> = ref(0);
const startTime: Ref<number> = ref(0);
const text: Ref<string> = ref('');
const textContainer: Ref<HTMLElement | null> = ref(null);
const time: Ref<number> = ref(0);
const totalLessons: Ref<number> = ref(0);
const typed: Ref<string> = ref('');

const { isCurrentWord }: Record<string, ComputedRef<boolean[]>> = useCurrentWord(text, typed);
const { progress }: Record<string, ComputedRef<number>> = useProgress(text, typed, isLessonCompleted);

const nextLesson: ComputedRef<number> = computed(
    (): number => (totalLessons.value - lessonNumber.value) ? lessonNumber.value + 1 : 0,
);

const resetState = (): void => {
    errors.value = 0;
    isLessonCompleted.value = false;
    speed.value = 0;
    startTime.value = 0;
    text.value = '';
    time.value = 0;
    typed.value = '';
    lesson.value = { id: 0, number: lessonNumber.value, newChars: '' };
};

const fetchLesson = async (): Promise<void> => {
    const response: AxiosResponse<any, any> = await axios.get(`/lessons/${language}/${lessonNumber.value}`);

    const { id, number, new_chars: newChars } = response.data.lesson;
    lesson.value = { id, number, newChars };

    totalLessons.value = response.data.lesson.total;
    text.value = response.data.lesson.text;
};

const onInput = async (): Promise<void> => {
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
        '/lessons/result',
        {
            lesson_id: lesson.value.id,
            language,
            time_seconds: time.value,
            speed_wpm: speed.value,
            errors: errors.value,
        }
    );
};

const onNext = async (): Promise<void> => {
    if (!isLessonCompleted.value) { return; }

    lessonNumber.value++;

    resetState();

    await fetchLesson();

    if (input.value) { input.value.focus(); }
};

onMounted(async (): Promise<void> => {
    resetState();

    await fetchLesson();
});
</script>
