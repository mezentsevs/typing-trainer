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
            <FinalTestSetup v-if="!text" :uploadFile @start="onStart" />
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
                    v-focus
                    @input="onInput"
                    class="w-full p-2 border rounded mt-4 resize-none"
                    :disabled="isTestCompleted"
                    rows="4"
                    spellcheck="false"
                />
                <VirtualKeyboard :language :typed :text :is-minimized="true" />
                <div v-if="isTestCompleted" class="flex justify-center mt-2">
                    <router-link to="/" class="w-32 bg-blue-500 text-center text-white p-2 rounded">
                        Finish
                    </router-link>
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
import { ComputedRef, Ref, ref } from 'vue';
import { KeyboardLanguageEnum } from '@/enums/KeyboardEnums';
import { RouteLocationNormalizedLoaded, useRoute } from 'vue-router';
import { useHandleTypingInput, useCurrentWord, useProgress } from '@/composables/TypingLogicComposables';

const route: RouteLocationNormalizedLoaded<string | symbol> = useRoute();
const { handleTypingInput }: Record<string, Function> = useHandleTypingInput();

const errors: Ref<number> = ref(0);
const genre: Ref<string> = ref('');
const isTestCompleted: Ref<boolean> = ref(false);
const language: KeyboardLanguageEnum = route.params.language as KeyboardLanguageEnum;
const speed: Ref<number> = ref(0);
const startTime: Ref<number> = ref(0);
const text: Ref<string> = ref('');
const textContainer: Ref<HTMLElement | null> = ref(null);
const time: Ref<number> = ref(0);
const typed: Ref<string> = ref('');

const { isCurrentWord }: Record<string, ComputedRef<boolean[]>> = useCurrentWord(text, typed);
const { progress }: Record<string, ComputedRef<number>> = useProgress(text, typed, isTestCompleted);

const resetState = (): void => {
    errors.value = 0;
    isTestCompleted.value = false;
    speed.value = 0;
    startTime.value = 0;
    time.value = 0;
    typed.value = '';
};

const fetchText = async (): Promise<void> => {
    const response = await axios.get('/test/text', { params: { language, genre: genre.value } });

    text.value = response.data.text;
};

const uploadFile = async (event: Event): Promise<void> => {
    const file = (event.target as HTMLInputElement).files?.[0];

    if (file) {
        const formData = new FormData();

        formData.append('file', file);
        formData.append('language', language);

        await axios.post('/test/upload', formData);
        await fetchText();
    }
};

const onInput = async (): Promise<void> => {
    await handleTypingInput(
        {
            errors,
            isCompleted: isTestCompleted,
            language,
            speed,
            startTime,
            text,
            textContainer,
            time,
            typed,
            progress,
        },
        '/test/result',
        {
            language,
            time_seconds: time.value,
            speed_wpm: speed.value,
            errors: errors.value,
        }
    );
};

const onStart = async (selectedGenre: string): Promise<void> => {
    resetState();

    genre.value = selectedGenre;

    await fetchText();
};
</script>
