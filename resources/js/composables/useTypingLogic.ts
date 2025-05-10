import LessonsProgressPayloadInterface from '@/interfaces/LessonsProgressPayloadInterface';
import TestResultPayloadInterface from '@/interfaces/TestResultPayloadInterface';
import TypingStateInterface from '@/interfaces/TypingStateInterface';
import axios from 'axios';
import { scrollToCurrentChar } from '@/helpers/DomHelper';

export default function useTypingLogic(): any {
    const handleTypingInput = async (
        state: TypingStateInterface,
        postUrl: string,
        payload: LessonsProgressPayloadInterface | TestResultPayloadInterface
    ): Promise<void> => {
        if (!state.startTime.value) { state.startTime.value = Date.now(); }

        const typedChars = state.typed.value.split('');
        let errorCount = 0;

        for (let i = 0; i < Math.min(typedChars.length, state.text.value.length); i++) {
            if (typedChars[i] !== state.text.value[i]) { errorCount++; }
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

    return { handleTypingInput };
}
