<template>
    <ContentCard v-if="text">
        <header class="flex flex-row items-center relative">
            <Heading :level="1" class="text-2xl">Final Test</Heading>
            <SuccessBanner
                v-if="isTestCompleted"
                class="absolute left-1/2 transform -translate-x-1/2"
            >
                Completed!
            </SuccessBanner>
        </header>

        <aside class="mt-4 flex flex-row justify-center">
            <StatisticsPanel :language :time :speed :errors :progress class="w-1/2" />
        </aside>

        <main>
            <TextContainer ref="textContainerRef" class="h-28 mt-4 text-lg font-mono">
                <span
                    v-for="(char, index) in text"
                    :key="index"
                    :class="{
                        'error-char': typed[index] && typed[index] !== char,
                        'current-word': isCurrentWord[index],
                        space: char === ' ',
                        'line-break': char === '\n',
                    }"
                >
                    {{ char }}
                </span>
            </TextContainer>
            <TextArea
                id="typed"
                v-model="typed"
                v-focus
                class="w-full mt-4 resize-none"
                :disabled="isTestCompleted"
                rows="4"
                spellcheck="false"
                @input="onInput"
            />
            <Keyboard :language :typed :text :is-minimized="true" />
            <div v-if="isTestCompleted" class="mb-4 flex flex-row justify-center">
                <PrimaryRouterLinkButton class="w-32">Finish</PrimaryRouterLinkButton>
            </div>
        </main>
    </ContentCard>
    <FinalTestSetup v-else :uploadFile :error @start="onStart" />
</template>

<script lang="ts" setup>
import ContentCard from '@/pages/partials/cards/ContentCard.vue';
import FinalTestSetup from '@/pages/partials/FinalTestSetup.vue';
import Heading from '@/components/uikit/headings/Heading.vue';
import Keyboard from '@/components/keyboards/Keyboard.vue';
import PrimaryRouterLinkButton from '@/components/uikit/buttons/PrimaryRouterLinkButton.vue';
import SaveResultRequestPayload from '@/interfaces/payloads/SaveResultRequestPayload';
import StatisticsPanel from '@/components/panels/StatisticsPanel.vue';
import SuccessBanner from '@/components/uikit/banners/SuccessBanner.vue';
import TextArea from '@/components/uikit/inputs/TextArea.vue';
import TextContainer from '@/components/uikit/containers/TextContainer.vue';
import TypingContext from '@/interfaces/typing/TypingContext';
import axios, { AxiosResponse } from 'axios';
import { ComputedRef, Ref, ref } from 'vue';
import { Language } from '@/enums/KeyboardEnums';
import { RouteLocationNormalizedLoaded, useRoute } from 'vue-router';
import { useHandleTypingInput, useCurrentWord, useProgress } from '@/composables/TypingComposables';

const route: RouteLocationNormalizedLoaded<string | symbol> = useRoute();
const { handleTypingInput }: Record<string, Function> = useHandleTypingInput();

const MAX_FILE_SIZE_KB: number = 3;
const error: Ref<string> = ref('');
const errors: Ref<number> = ref(0);
const genre: Ref<string> = ref('');
const isTestCompleted: Ref<boolean> = ref(false);
const language: Language = route.params.language as Language;
const speed: Ref<number> = ref(0);
const startTime: Ref<number> = ref(0);
const text: Ref<string> = ref('');
const textContainer: Ref<HTMLElement | null> = ref(null);
const textContainerRef: Ref<typeof TextContainer | null> = ref(null);
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
        if (err instanceof Error) {
            error.value = 'Upload failed';
        }
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
        } as TypingContext,
        '/test/result',
        {
            language,
            time_seconds: time.value,
            speed_wpm: speed.value,
            errors: errors.value,
        } as SaveResultRequestPayload,
    );
};

const onStart = async (selectedGenre: string): Promise<void> => {
    resetState();

    genre.value = selectedGenre;

    await fetchText();

    if (textContainerRef.value) {
        textContainer.value = textContainerRef.value.getContainerElement();
    }
};
</script>
