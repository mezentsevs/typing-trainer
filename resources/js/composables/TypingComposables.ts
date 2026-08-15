import { computed, ComputedRef, Ref, ref } from 'vue';
import axios from 'axios';

import { getCurrentTypingUnit } from '@/helpers/StringHelper';
import { isSuccess } from '@/helpers/TypingHelper';
import { scrollToCurrentChar } from '@/helpers/DomHelper';
import SaveResultRequestPayload from '@/interfaces/payloads/SaveResultRequestPayload';
import TypingContext from '@/interfaces/typing/TypingContext';
import TypingUnit from '@/interfaces/typing/TypingUnit';

export interface UseHandleTypingInputReturn {
    handleTypingInput: (
        context: TypingContext,
        saveResultRequestUrl: string,
        saveResultRequestPayload: SaveResultRequestPayload,
    ) => Promise<void>;
    cleanupScrollThrottle: () => void;
}

export const useHandleTypingInput = (): UseHandleTypingInputReturn => {
    let scrollThrottleTimeout: ReturnType<typeof setTimeout> | null = null;

    const scrollToCurrentCharThrottled = (container: HTMLElement | null, index: number): void => {
        if (scrollThrottleTimeout) return;
        scrollToCurrentChar(container, index);
        scrollThrottleTimeout = setTimeout((): void => {
            scrollThrottleTimeout = null;
        }, 100);
    };

    const handleTypingInput = async (
        context: TypingContext,
        saveResultRequestUrl: string,
        saveResultRequestPayload: SaveResultRequestPayload,
    ): Promise<void> => {
        if (!context.startTime.value) {
            context.startTime.value = Date.now();
        }

        const textLength: number = context.text.value.length;
        const typedLength: number = context.typed.value.length;
        let errorCount: number = 0;

        for (let i: number = 0; i < Math.min(typedLength, textLength); i++) {
            if (context.typed.value.charAt(i) !== context.text.value.charAt(i)) {
                errorCount++;
            }
        }

        context.errors.value = errorCount;

        if (typedLength >= textLength) {
            context.typed.value = context.typed.value.slice(0, textLength);
            context.isCompleted.value = true;
            context.isSuccessful.value = isSuccess(textLength, context.errors.value);

            await axios.post(saveResultRequestUrl, saveResultRequestPayload);

            return;
        }

        context.time.value = Math.round((Date.now() - context.startTime.value) / 1000);
        const words: number = typedLength / 5;
        context.speed.value =
            context.time.value > 0 ? Math.round((words / context.time.value) * 60) : 0;

        scrollToCurrentCharThrottled(context.textContainer.value, typedLength);
    };

    const cleanupScrollThrottle = (): void => {
        if (scrollThrottleTimeout) {
            clearTimeout(scrollThrottleTimeout);
            scrollThrottleTimeout = null;
        }
    };

    return { handleTypingInput, cleanupScrollThrottle };
};

export const useCurrentWord = (
    text: Ref<string>,
    typed: Ref<string>,
): Record<string, ComputedRef<TypingUnit>> => {
    const isCurrentWord: Ref<TypingUnit> = ref({ start: -1, end: -1 });
    let lastStart: number = -1;
    let lastEnd: number = -1;

    const updateCurrentWord = (): void => {
        const unit: TypingUnit | null = getCurrentTypingUnit(text.value, typed.value.length);

        if (!unit) {
            isCurrentWord.value = { start: -1, end: -1 };
            lastStart = -1;
            lastEnd = -1;
            return;
        }

        if (unit.start === lastStart && unit.end === lastEnd) {
            return;
        }

        lastStart = unit.start;
        lastEnd = unit.end;
        isCurrentWord.value = { start: unit.start, end: unit.end };
    };

    return {
        isCurrentWord: computed((): TypingUnit => {
            updateCurrentWord();
            return isCurrentWord.value;
        }),
    };
};

export const useProgress = (
    text: Ref<string>,
    typed: Ref<string>,
    isCompleted: Ref<boolean>,
): Record<string, ComputedRef<number>> => {
    const progress: ComputedRef<number> = computed((): number => {
        if (isCompleted.value) {
            return 100;
        }

        return text.value.length ? Math.floor((typed.value.length / text.value.length) * 100) : 0;
    });

    return { progress };
};
