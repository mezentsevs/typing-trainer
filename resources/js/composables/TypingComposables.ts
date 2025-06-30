import ResultPayload from '@/interfaces/ResultPayload';
import TypingState from '@/interfaces/TypingState';
import axios from 'axios';
import { TypingUnitType } from '@/types/TypingTypes';
import { computed, ComputedRef, Ref } from 'vue';
import { getCurrentTypingUnit } from '@/helpers/StringHelper';
import { scrollToCurrentChar } from '@/helpers/DomHelper';

export function useHandleTypingInput(): Record<string, Function> {
    const handleTypingInput = async (
        state: TypingState,
        postUrl: string,
        payload: ResultPayload,
    ): Promise<void> => {
        if (!state.startTime.value) { state.startTime.value = Date.now(); }

        const typedChars: string[] = state.typed.value.split('');
        let errorCount: number = 0;

        for (let i: number = 0; i < Math.min(typedChars.length, state.text.value.length); i++) {
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
        const words: number = state.typed.value.length / 5;
        state.speed.value = state.time.value > 0 ? Math.round((words / state.time.value) * 60) : 0;

        scrollToCurrentChar(state.textContainer.value, state.typed.value.length);
    };

    return { handleTypingInput };
}

export function useCurrentWord(text: Ref<string>, typed: Ref<string>): Record<string, ComputedRef<boolean[]>> {
    const currentTypingUnit: ComputedRef<TypingUnitType> = computed(
        (): TypingUnitType => getCurrentTypingUnit(text.value, typed.value.length),
    );

    const isCurrentWord: ComputedRef<boolean[]> = computed((): boolean[] => {
        const range: TypingUnitType = currentTypingUnit.value;
        const arr: boolean[] = Array(text.value.length).fill(false) as boolean[];

        if (!range) { return arr; }

        for (let i: number = range.start; i <= range.end; i++) { arr[i] = true; }

        return arr;
    });

    return { isCurrentWord };
}

export function useProgress(text: Ref<string>, typed: Ref<string>, isCompleted: Ref<boolean>): Record<string, ComputedRef<number>> {
    const progress: ComputedRef<number> = computed((): number => {
        if (isCompleted.value) { return 100; }

        return text.value.length ? Math.floor((typed.value.length / text.value.length) * 100) : 0;
    });

    return { progress };
}
