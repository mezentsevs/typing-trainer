<template>
    <ContentCard v-if="text" :key="currentKey">
        <header class="flex flex-row items-center relative">
            <Heading :level="1" class="text-2xl">Final Test</Heading>
            <SuccessBanner
                v-if="isCompleted && isSuccessful"
                class="absolute left-1/2 transform -translate-x-1/2">
                Success!
            </SuccessBanner>
            <FailureBanner
                v-else-if="isCompleted"
                class="absolute left-1/2 transform -translate-x-1/2">
                Failure.
            </FailureBanner>
        </header>

        <aside class="mt-6 flex flex-row justify-center">
            <StatisticsPanel :language :time :speed :errors :progress class="w-1/2" />
        </aside>

        <main>
            <TextContainer ref="textContainerRef" class="h-28 mt-4 text-lg font-mono">
                <TypingText :text :typed :is-current-word :is-completed="isCompleted" />
            </TextContainer>
            <TextArea
                id="typed"
                v-model="typed"
                v-focus
                class="w-full mt-4 resize-none"
                :disabled="isCompleted"
                rows="4"
                spellcheck="false"
                @input="onInput" />
            <Keyboard
                :is-minimized="true"
                :layout="keyboardLayout"
                :text
                :typed
                :upper-or-special-regex="upperOrSpecialRegex"
                class="mt-4" />
            <div v-if="isCompleted" class="mt-6 flex flex-row justify-center">
                <PrimaryRouterLinkButton class="w-32 animate-pulse-scale-once">
                    Finish
                </PrimaryRouterLinkButton>
            </div>
        </main>
    </ContentCard>
    <FinalTestSetup v-else :error :loading="isTestLoading" :onUpload @start="onStart" />
</template>

<script lang="ts" setup>
import { BaseSaveResultRequestPayload } from '@/interfaces/payloads/SaveResultRequestPayload';
import { ComputedRef, Ref, ref, onUnmounted, nextTick } from 'vue';
import { languageRegistry } from '@/languages/registry/LanguageRegistry';
import { RouteLocationNormalizedLoaded, useRoute } from 'vue-router';
import {
    useHandleTypingInput,
    useCurrentWord,
    useProgress,
    UseHandleTypingInputReturn,
} from '@/composables/TypingComposables';
import axios, { AxiosResponse } from 'axios';
import ContentCard from '@/pages/partials/cards/ContentCard.vue';
import FailureBanner from '@/components/uikit/banners/FailureBanner.vue';
import FinalTestSetup from '@/pages/partials/FinalTestSetup.vue';
import Heading from '@/components/uikit/headings/Heading.vue';
import Keyboard from '@/components/keyboards/Keyboard.vue';
import PrimaryRouterLinkButton from '@/components/uikit/buttons/PrimaryRouterLinkButton.vue';
import StatisticsPanel from '@/components/panels/StatisticsPanel.vue';
import SuccessBanner from '@/components/uikit/banners/SuccessBanner.vue';
import TextArea from '@/components/uikit/inputs/TextArea.vue';
import TextContainer from '@/components/uikit/containers/TextContainer.vue';
import TypingContext from '@/interfaces/typing/TypingContext';
import TypingText from '@/components/typing/TypingText.vue';
import TypingUnit from '@/interfaces/typing/TypingUnit';
import type { KeyboardLayout } from '@/types/KeyboardTypes';
import type Language from '@/languages/contracts/Language';

const route: RouteLocationNormalizedLoaded<string | symbol> = useRoute();
const { handleTypingInput, cleanupScrollThrottle }: UseHandleTypingInputReturn =
    useHandleTypingInput();

const currentKey: Ref<string> = ref(crypto.randomUUID());
const error: Ref<string> = ref('');
const errors: Ref<number> = ref(0);
const isCompleted: Ref<boolean> = ref(false);
const isSuccessful: Ref<boolean> = ref(false);
const isTestLoading: Ref<boolean> = ref(false);
const selectedFile: Ref<File | null> = ref(null);
const speed: Ref<number> = ref(0);
const startTime: Ref<number> = ref(0);
const text: Ref<string> = ref('');
const textContainer: Ref<HTMLElement | null> = ref(null);
const textContainerRef: Ref<typeof TextContainer | null> = ref(null);
const time: Ref<number> = ref(0);
const typed: Ref<string> = ref('');
let genre: string = '';

const MAX_FILE_SIZE_KB: number = 3;
const language: string = route.params.language as string;

const languageObject: Language = languageRegistry.getSupportedOrDefault(language);
const keyboardLayout: KeyboardLayout = languageObject.getKeyboardLayout();
const upperOrSpecialRegex: RegExp = languageObject.getUpperOrSpecialRegex();

const { isCurrentWord }: Record<string, ComputedRef<TypingUnit>> = useCurrentWord(text, typed);
const { progress }: Record<string, ComputedRef<number>> = useProgress(text, typed, isCompleted);

const prepareTest = (): void => {
    currentKey.value = crypto.randomUUID();
};

const resetState = (): void => {
    errors.value = 0;
    isCompleted.value = false;
    isSuccessful.value = false;
    speed.value = 0;
    startTime.value = 0;
    time.value = 0;
    typed.value = '';
};

const fetchTest = async (): Promise<void> => {
    const response: AxiosResponse<{
        text: string;
    }> = await axios.get('/test/retrieve', { params: { language, genre } });

    text.value = response.data.text;
};

const updateTextContainer = (): void => {
    if (textContainerRef.value) {
        textContainer.value = textContainerRef.value.getContainerElement();
    }
};

const afterTestFetched = async (): Promise<void> => {
    await nextTick();
    updateTextContainer();
};

const loadTest = async (): Promise<void> => {
    try {
        await fetchTest();
        await afterTestFetched();
        error.value = '';
    } catch {
        error.value = 'Test loading failed';
    }
};

const uploadFile = async (file: File): Promise<void> => {
    try {
        if (file.size > MAX_FILE_SIZE_KB * 1024) {
            error.value = `Uploaded file size exceeded (max ${MAX_FILE_SIZE_KB} KB)`;
            return;
        }

        const formData = new FormData();
        formData.append('file', file);
        formData.append('language', language);

        await axios.post('/test/upload', formData);
        await fetchTest();
        await afterTestFetched();
        selectedFile.value = null;
        error.value = '';
    } catch (err) {
        if (err instanceof Error) {
            error.value = 'File uploading failed';
        }
    }
};

const onUpload = (event: Event): void => {
    const file = (event.target as HTMLInputElement).files?.[0];

    if (file) {
        selectedFile.value = file;
        uploadFile(file);
    }
};

const onInput = async (): Promise<void> => {
    await handleTypingInput(
        {
            errors,
            isCompleted,
            isSuccessful,
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
        } as BaseSaveResultRequestPayload,
    );
};

const onStart = async (selectedGenre: string): Promise<void> => {
    isTestLoading.value = true;
    prepareTest();
    resetState();
    genre = selectedGenre;

    if (selectedFile.value) {
        await uploadFile(selectedFile.value);
    } else {
        await loadTest();
    }

    isTestLoading.value = false;
};

onUnmounted((): void => {
    resetState();
    cleanupScrollThrottle();
});
</script>
