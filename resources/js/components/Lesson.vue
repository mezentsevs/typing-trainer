<template>
    <ContentCard>
        <header class="mb-4 relative flex items-center">
            <Heading :level="2" class="text-2xl">Lesson {{ lessonPartialInfo.number }}/{{ totalLessons }}</Heading>
            <SuccessBanner v-if="isLessonCompleted" class="absolute left-1/2 transform -translate-x-1/2">
                Completed!
            </SuccessBanner>
        </header>

        <aside class="mb-4 flex flex-row items-stretch space-x-4">
            <NewCharacters :new-chars="lessonPartialInfo.new_chars" class="flex items-center justify-center" />
            <Statistics :language :time :speed :errors :progress />
        </aside>

        <main>
            <TextContainer ref="textContainerRef" class="h-28 mb-4 p-2 text-lg font-mono">
                <span v-for="(char, index) in text"
                      :key="index"
                      :class="{
                          'error-char': typed[index] && typed[index] !== char,
                           'current-word': isCurrentWord[index],
                           'space': char === ' ',
                           'line-break': char === '\n',
                      }"
                >
                    {{ char }}
                </span>
            </TextContainer>
            <TextArea
                id="typed"
                ref="textArea"
                v-model="typed"
                v-focus
                class="w-full p-2 mt-4 resize-none"
                @input="onInput"
                :disabled="isLessonCompleted"
                rows="4"
                spellcheck="false"
            />
            <VirtualKeyboard :language :typed :text />
            <div v-if="isLessonCompleted" class="flex justify-center mt-4">
                <PrimaryRouterLinkButton
                    v-if="nextLesson"
                    :to="`/lesson/${language}/${nextLesson}`"
                    @click="onNext"
                    class="w-32"
                >
                    Next
                </PrimaryRouterLinkButton>
                <SuccessRouterLinkButton
                    v-else
                    :to="`/test/${language}`"
                    class="w-32"
                >
                    Final Test
                </SuccessRouterLinkButton>
            </div>
        </main>
    </ContentCard>
</template>

<script lang="ts" setup>
import ContentCard from '@/components/cards/ContentCard.vue';
import Heading from '@/components/uikit/Heading.vue';
import Lesson from '@/interfaces/Lesson';
import NewCharacters from './NewCharacters.vue';
import PrimaryRouterLinkButton from '@/components/uikit/PrimaryRouterLinkButton.vue';
import Statistics from './Statistics.vue';
import SuccessBanner from '@/components/uikit/SuccessBanner.vue';
import SuccessRouterLinkButton from '@/components/uikit/SuccessRouterLinkButton.vue';
import TextArea from '@/components/uikit/TextArea.vue';
import TextContainer from '@/components/uikit/TextContainer.vue';
import VirtualKeyboard from './VirtualKeyboard.vue';
import axios, { AxiosResponse } from 'axios';
import { KeyboardLanguageEnum } from '@/enums/KeyboardEnums';
import { LessonPartialInfoType } from '@/types/LessonTypes';
import { RouteLocationNormalizedLoaded, useRoute } from 'vue-router';
import { ref, computed, onMounted, Ref, ComputedRef } from 'vue';
import { useHandleTypingInput, useCurrentWord, useProgress } from '@/composables/TypingComposables';

const route: RouteLocationNormalizedLoaded<string | symbol> = useRoute();
const { handleTypingInput }: Record<string, Function> = useHandleTypingInput();

const errors: Ref<number> = ref(0);
const isLessonCompleted: Ref<boolean> = ref(false);
const language: KeyboardLanguageEnum = route.params.language as KeyboardLanguageEnum;
const lessonNumber: Ref<number> = ref(parseInt(route.params.number as string));
const lessonPartialInfo: Ref<LessonPartialInfoType> = ref({ id: 0, number: lessonNumber.value, new_chars: '' });
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
    lessonPartialInfo.value = { id: 0, number: lessonNumber.value, new_chars: '' } as LessonPartialInfoType;
};

// TODO: Try to use only Lesson interface everywhere
const fetchLesson = async (): Promise<void> => {
    const response: AxiosResponse<{
        lesson: Lesson;
    }> = await axios.get(`/lessons/${language}/${lessonNumber.value}`);

    const { id, number, new_chars }: LessonPartialInfoType = response.data.lesson;
    lessonPartialInfo.value = { id, number, new_chars } as LessonPartialInfoType;

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
            lesson_id: lessonPartialInfo.value.id,
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

    if (textArea.value) { textArea.value.area.focus(); }
};

onMounted(async (): Promise<void> => {
    resetState();

    await fetchLesson();

    if (textContainerRef.value) { textContainer.value = textContainerRef.value.getContainerElement(); }
});
</script>
