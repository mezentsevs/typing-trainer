<template>
    <ContentCard v-if="text" :key="currentKey">
        <header class="flex flex-row items-center relative">
            <Heading :level="1" class="text-2xl">
                Lesson
                <template v-if="lesson">{{ lesson.number }}/{{ lesson.total }}</template>
            </Heading>
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

        <aside class="mt-6 flex flex-row items-stretch space-x-4">
            <NewCharactersPanel :new-chars="lesson?.new_chars ?? ''" class="w-1/2" />
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
            <Keyboard :language :typed :text class="mt-4" />
            <div v-if="isCompleted" class="mt-6 flex flex-row justify-center">
                <PrimaryRouterLinkButton
                    v-if="nextLessonNumber"
                    :to="`/lesson/${language}/${nextLessonNumber}`"
                    class="w-32 animate-pulse-scale-once"
                    @click="onNext">
                    Next
                </PrimaryRouterLinkButton>
                <SuccessRouterLinkButton
                    v-else
                    :to="`/test/${language}`"
                    class="w-32 animate-pulse-scale-once">
                    Final Test
                </SuccessRouterLinkButton>
            </div>
        </main>
    </ContentCard>
    <div v-else class="min-h-screen flex flex-col items-center justify-center">
        <template v-if="loadError">
            <ErrorMessage message="Lesson loading failed" />
            <PrimaryButton :type="Button.Button" class="w-32 mt-4" @click="onRetry">
                Retry
            </PrimaryButton>
        </template>
        <LoadingSpinner v-else />
    </div>
</template>

<script lang="ts" setup>
import { Button } from '@/enums/UIKitEnums';
import { Language } from '@/enums/KeyboardEnums';
import { ref, computed, onMounted, onUnmounted, Ref, ComputedRef, nextTick } from 'vue';
import { RouteLocationNormalizedLoaded, useRoute } from 'vue-router';
import {
    useHandleTypingInput,
    useCurrentWord,
    useProgress,
    UseHandleTypingInputReturn,
} from '@/composables/TypingComposables';
import axios, { AxiosResponse } from 'axios';
import ContentCard from '@/pages/partials/cards/ContentCard.vue';
import ErrorMessage from '@/components/uikit/messages/ErrorMessage.vue';
import FailureBanner from '@/components/uikit/banners/FailureBanner.vue';
import Heading from '@/components/uikit/headings/Heading.vue';
import Keyboard from '@/components/keyboards/Keyboard.vue';
import Lesson from '@/interfaces/Lesson';
import LoadingSpinner from '@/components/uikit/spinners/LoadingSpinner.vue';
import NewCharactersPanel from '@/components/panels/NewCharactersPanel.vue';
import PrimaryButton from '@/components/uikit/buttons/PrimaryButton.vue';
import PrimaryRouterLinkButton from '@/components/uikit/buttons/PrimaryRouterLinkButton.vue';
import SaveResultRequestPayload from '@/interfaces/payloads/SaveResultRequestPayload';
import StatisticsPanel from '@/components/panels/StatisticsPanel.vue';
import SuccessBanner from '@/components/uikit/banners/SuccessBanner.vue';
import SuccessRouterLinkButton from '@/components/uikit/buttons/SuccessRouterLinkButton.vue';
import TextArea from '@/components/uikit/inputs/TextArea.vue';
import TextContainer from '@/components/uikit/containers/TextContainer.vue';
import TypingContext from '@/interfaces/typing/TypingContext';
import TypingText from '@/components/typing/TypingText.vue';
import TypingUnit from '@/interfaces/typing/TypingUnit';

const route: RouteLocationNormalizedLoaded<string | symbol> = useRoute();
const { handleTypingInput, cleanupScrollThrottle }: UseHandleTypingInputReturn =
    useHandleTypingInput();

const currentKey: Ref<string> = ref(crypto.randomUUID());
const errors: Ref<number> = ref(0);
const isCompleted: Ref<boolean> = ref(false);
const isSuccessful: Ref<boolean> = ref(false);
const lesson: Ref<Lesson | null> = ref(null);
const loadError: Ref<boolean> = ref(false);
const speed: Ref<number> = ref(0);
const startTime: Ref<number> = ref(0);
const text: Ref<string> = ref('');
const textContainer: Ref<HTMLElement | null> = ref(null);
const textContainerRef: Ref<typeof TextContainer | null> = ref(null);
const time: Ref<number> = ref(0);
const typed: Ref<string> = ref('');

const { isCurrentWord }: Record<string, ComputedRef<TypingUnit>> = useCurrentWord(text, typed);
const { progress }: Record<string, ComputedRef<number>> = useProgress(text, typed, isCompleted);

const language: Language = route.params.language as Language;

let lessonNumber: number = parseInt(route.params.number as string);

const nextLessonNumber: ComputedRef<number> = computed((): number => {
    if (!lesson.value) {
        return 0;
    }

    return lesson.value.number < lesson.value.total ? lesson.value.number + 1 : 0;
});

const prepareNextLesson = (): void => {
    currentKey.value = crypto.randomUUID();
    lessonNumber++;
};

const resetState = (): void => {
    errors.value = 0;
    isCompleted.value = false;
    isSuccessful.value = false;
    lesson.value = null;
    speed.value = 0;
    startTime.value = 0;
    text.value = '';
    time.value = 0;
    typed.value = '';
};

const fetchLesson = async (): Promise<void> => {
    const response: AxiosResponse<{ lesson: Lesson }> = await axios.get(
        `/lessons/${language}/${lessonNumber}`,
    );

    lesson.value = response.data.lesson;
    text.value = response.data.lesson.text;
};

const updateTextContainer = (): void => {
    if (textContainerRef.value) {
        textContainer.value = textContainerRef.value.getContainerElement();
    }
};

const afterLessonFetched = async (): Promise<void> => {
    await nextTick();
    updateTextContainer();
};

const loadLesson = async (): Promise<void> => {
    try {
        await fetchLesson();
        await afterLessonFetched();
        loadError.value = false;
    } catch {
        loadError.value = true;
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
        '/lessons/result',
        {
            lesson_id: lesson.value?.id,
            language,
            time_seconds: time.value,
            speed_wpm: speed.value,
            errors: errors.value,
        } as SaveResultRequestPayload,
    );
};

const onNext = async (): Promise<void> => {
    if (!isCompleted.value) {
        return;
    }

    prepareNextLesson();
    resetState();
    await loadLesson();
};

const onRetry = async (): Promise<void> => {
    await loadLesson();
};

onMounted(async (): Promise<void> => {
    resetState();
    await loadLesson();
});

onUnmounted((): void => {
    resetState();
    cleanupScrollThrottle();
});
</script>
