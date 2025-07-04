<template>
    <FinalTestSetup v-if="!text" :uploadFile :error @start="onStart" />
    <ContentCard v-else>
        <div class="mb-4 relative flex items-center">
            <Heading :level="2" class="text-2xl">Final Test</Heading>
            <span v-if="isTestCompleted"
                  class="absolute left-1/2 transform -translate-x-1/2 text-green-500 text-3xl font-bold"
            >
                    Completed!
                </span>
        </div>
        <Statistics class="mb-8" v-if="text" :language :time :speed :errors :progress />
        <template v-if="text">
            <div ref="textContainer" class="mb-4 text-lg font-mono break-words whitespace-pre-wrap h-28 overflow-y-auto bg-gray-50 p-2">
                    <span v-for="(char, index) in text"
                          :key="index"
                          :class="{ 'error-char': typed[index] && typed[index] !== char, 'current-word': isCurrentWord[index], 'space': char === ' ', 'line-break': char === '\n' }"
                    >
                        {{ char }}
                    </span>
            </div>
            <TextArea
                id="typed"
                v-model="typed"
                v-focus
                class="w-full p-2 mt-4 resize-none"
                @input="onInput"
                :disabled="isTestCompleted"
                rows="4"
                spellcheck="false"
            />
            <VirtualKeyboard :language :typed :text :is-minimized="true" />
            <div v-if="isTestCompleted" class="flex justify-center mt-2">
                <PrimaryRouterLinkButton class="w-32">Finish</PrimaryRouterLinkButton>
            </div>
        </template>
    </ContentCard>
</template>

<script lang="ts" setup>
import ContentCard from '@/components/cards/ContentCard.vue';
import FinalTestSetup from './FinalTestSetup.vue';
import Heading from '@/components/uikit/Heading.vue';
import PrimaryRouterLinkButton from '@/components/uikit/PrimaryRouterLinkButton.vue';
import Statistics from './Statistics.vue';
import TextArea from '@/components/uikit/TextArea.vue';
import VirtualKeyboard from './VirtualKeyboard.vue';
import axios, { AxiosResponse } from 'axios';
import { ComputedRef, Ref, ref } from 'vue';
import { KeyboardLanguageEnum } from '@/enums/KeyboardEnums';
import { RouteLocationNormalizedLoaded, useRoute } from 'vue-router';
import { useHandleTypingInput, useCurrentWord, useProgress } from '@/composables/TypingComposables';

const route: RouteLocationNormalizedLoaded<string | symbol> = useRoute();
const { handleTypingInput }: Record<string, Function> = useHandleTypingInput();

const MAX_FILE_SIZE_KB: number = 3;
const error: Ref<string> = ref('');
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
    const response: AxiosResponse<{
        text: string;
    }> = await axios.get('/test/text', { params: { language, genre: genre.value } });

    text.value = response.data.text;
};

const uploadFile = async (event: Event): Promise<void> => {
    try {
        const file = (event.target as HTMLInputElement).files?.[0];

        if (file) {
            if (file.size > MAX_FILE_SIZE_KB * 1024) {
                error.value = `Uploaded file size exceeded (max ${MAX_FILE_SIZE_KB} KB)`;

                return;
            }

            const formData = new FormData();

            formData.append('file', file);
            formData.append('language', language);

            await axios.post('/test/upload', formData);
            await fetchText();
        }
    } catch (err) {
        if (err instanceof Error) { error.value = 'Upload failed'; }
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
