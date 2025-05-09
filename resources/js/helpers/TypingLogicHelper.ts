import { Ref, ComputedRef } from 'vue';
import axios from 'axios';
import { scrollToCurrentChar } from '@/helpers/DomHelper';

interface TypingState {
    errors: Ref<number>;
    isCompleted: Ref<boolean>;
    language: string;
    speed: Ref<number>;
    startTime: Ref<number>;
    text: Ref<string>;
    textContainer: Ref<HTMLElement | null>;
    time: Ref<number>;
    typed: Ref<string>;
    progress: ComputedRef<number>;
}

interface LessonPayload {
    lesson_id: number;
    language: string;
    time_seconds: number;
    speed_wpm: number;
    errors: number;
}

interface TestPayload {
    language: string;
    time_seconds: number;
    speed_wpm: number;
    errors: number;
}

export const handleTypingInput = async (
    state: TypingState,
    postUrl: string,
    payload: LessonPayload | TestPayload
) => {
    if (!state.startTime.value) {
        state.startTime.value = Date.now();
    }

    const typedChars = state.typed.value.split('');
    let errorCount = 0;

    for (let i = 0; i < Math.min(typedChars.length, state.text.value.length); i++) {
        if (typedChars[i] !== state.text.value[i]) {
            errorCount++;
        }
    }

    state.errors.value = errorCount;

    if (state.typed.value.length >= state.text.value.length) {
        state.typed.value = state.typed.value.slice(0, state.text.value.length);
        state.isCompleted.value = true;

        await axios.post(postUrl, payload);
        return;
    }

    state.time.value = Math.round((Date.now() - state.startTime.value) / 1000);
    const words = state.typed.value.length / 5;
    state.speed.value = state.time.value > 0 ? Math.round((words / state.time.value) * 60) : 0;

    scrollToCurrentChar(state.textContainer.value, state.typed.value.length);
};
