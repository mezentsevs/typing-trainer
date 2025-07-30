<template>
    <ContentCard>
        <header class="flex flex-row items-center relative">
            <Heading :level="1" class="text-2xl">
                Lesson {{ lessonPartialInfo.number }}/{{ totalLessons }}
            </Heading>
            <SuccessBanner
                v-if="isLessonCompleted"
                class="absolute left-1/2 transform -translate-x-1/2">
                Completed!
            </SuccessBanner>
        </header>

        <aside class="mt-4 flex flex-row items-stretch space-x-4">
            <NewCharactersPanel :new-chars="lessonPartialInfo.new_chars" class="w-1/2" />
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
                    }">
                    {{ char }}
                </span>
            </TextContainer>
            <TextArea
                id="typed"
                ref="textArea"
                v-model="typed"
                v-focus
                class="w-full mt-4 resize-none"
                :disabled="isLessonCompleted"
                rows="4"
                spellcheck="false"
                @input="onInput" />
            <Keyboard :language :typed :text />
            <div v-if="isLessonCompleted" class="mb-4 flex flex-row justify-center">
                <PrimaryRouterLinkButton
                    v-if="nextLesson"
                    :to="`/lesson/${language}/${nextLesson}`"
                    class="w-32"
                    @click="onNext">
                    Next
                </PrimaryRouterLinkButton>
                <SuccessRouterLinkButton v-else :to="`/test/${language}`" class="w-32">
                    Final Test
                </SuccessRouterLinkButton>
            </div>
        </main>
    </ContentCard>
</template>

<script lang="ts" setup>
import ContentCard from '@/pages/partials/cards/ContentCard.vue';
import Heading from '@/components/uikit/headings/Heading.vue';
import Keyboard from '@/components/keyboards/Keyboard.vue';
import Lesson from '@/interfaces/Lesson';
import NewCharactersPanel from '@/components/panels/NewCharactersPanel.vue';
import PrimaryRouterLinkButton from '@/components/uikit/buttons/PrimaryRouterLinkButton.vue';
import SaveResultRequestPayload from '@/interfaces/payloads/SaveResultRequestPayload';
import StatisticsPanel from '@/components/panels/StatisticsPanel.vue';
import SuccessBanner from '@/components/uikit/banners/SuccessBanner.vue';
import SuccessRouterLinkButton from '@/components/uikit/buttons/SuccessRouterLinkButton.vue';
import TextArea from '@/components/uikit/inputs/TextArea.vue';
import TextContainer from '@/components/uikit/containers/TextContainer.vue';
import TypingContext from '@/interfaces/typing/TypingContext';
import axios, { AxiosResponse } from 'axios';
import { Language } from '@/enums/KeyboardEnums';
import { LessonPartialInfo } from '@/types/LessonTypes';
import { RouteLocationNormalizedLoaded, useRoute } from 'vue-router';
import { ref, computed, onMounted, Ref, ComputedRef } from 'vue';
import { useHandleTypingInput, useCurrentWord, useProgress } from '@/composables/TypingComposables';

const route: RouteLocationNormalizedLoaded<string | symbol> = useRoute();
const { handleTypingInput }: Record<string, Function> = useHandleTypingInput();

const errors: Ref<number> = ref(0);
const isLessonCompleted: Ref<boolean> = ref(false);
const language: Language = route.params.language as Language;
const lessonNumber: Ref<number> = ref(parseInt(route.params.number as string));
const lessonPartialInfo: Ref<LessonPartialInfo> = ref({
    id: 0,
    number: lessonNumber.value,
    new_chars: '',
});
const speed: Ref<number> = ref(0);
const startTime: Ref<number> = ref(0);
const text: Ref<string> = ref('');
const textArea: Ref<typeof TextArea | null> = ref(null);
const textContainer: Ref<HTMLElement | null> = ref(null);
const textContainerRef: Ref<typeof TextContainer | null> = ref(null);
const time: Ref<number> = ref(0);
const totalLessons: Ref<number> = ref(0);
const typed: Ref<string> = ref('');

const { isCurrentWord }: Record<string, ComputedRef<boolean[]>> = useCurrentWord(text, typed);
const {
    progress,
}: Record<string, ComputedRef<number>> = useProgress(text, typed, isLessonCompleted);

const nextLesson: ComputedRef<number> = computed((): number =>
    totalLessons.value - lessonNumber.value ? lessonNumber.value + 1 : 0,
);

const resetState = (): void => {
    errors.value = 0;
    isLessonCompleted.value = false;
    speed.value = 0;
    startTime.value = 0;
    text.value = '';
    time.value = 0;
    typed.value = '';
    lessonPartialInfo.value = {
        id: 0,
        number: lessonNumber.value,
        new_chars: '',
    } as LessonPartialInfo;
};

// TODO: Try to use only Lesson interface everywhere
const fetchLesson = async (): Promise<void> => {
    const response: AxiosResponse<{
        lesson: Lesson;
    }> = await axios.get(`/lessons/${language}/${lessonNumber.value}`);

    const { id, number, new_chars }: LessonPartialInfo = response.data.lesson;
    lessonPartialInfo.value = { id, number, new_chars } as LessonPartialInfo;

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
        } as TypingContext,
        '/lessons/result',
        {
            lesson_id: lessonPartialInfo.value.id,
            language,
            time_seconds: time.value,
            speed_wpm: speed.value,
            errors: errors.value,
        } as SaveResultRequestPayload,
    );
};

const onNext = async (): Promise<void> => {
    if (!isLessonCompleted.value) {
        return;
    }

    lessonNumber.value++;

    resetState();

    await fetchLesson();

    if (textArea.value) {
        textArea.value.area.focus();
    }
};

onMounted(async (): Promise<void> => {
    resetState();

    await fetchLesson();

    if (textContainerRef.value) {
        textContainer.value = textContainerRef.value.getContainerElement();
    }
});
</script>
