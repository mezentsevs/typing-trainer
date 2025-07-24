import SaveResultRequestPayload from '@/interfaces/payloads/SaveResultRequestPayload';
import TypingContext from '@/interfaces/typing/TypingContext';
import TypingUnit from '@/interfaces/typing/TypingUnit';
import axios from 'axios';
import { computed, ComputedRef, Ref } from 'vue';
import { getCurrentTypingUnit } from '@/helpers/StringHelper';
import { scrollToCurrentChar } from '@/helpers/DomHelper';

export const useHandleTypingInput = (): Record<string, Function> => {
    const handleTypingInput = async (
        context: TypingContext,
        saveResultRequestUrl: string,
        saveResultRequestPayload: SaveResultRequestPayload,
    ): Promise<void> => {
        if (!context.startTime.value) { context.startTime.value = Date.now(); }

        const typedChars: string[] = context.typed.value.split('');
        let errorCount: number = 0;

        for (let i: number = 0; i < Math.min(typedChars.length, context.text.value.length); i++) {
            if (typedChars[i] !== context.text.value[i]) { errorCount++; }
        }

        context.errors.value = errorCount;

        if (context.typed.value.length >= context.text.value.length) {
            context.typed.value = context.typed.value.slice(0, context.text.value.length);
            context.isCompleted.value = true;

            await axios.post(saveResultRequestUrl, saveResultRequestPayload);

            return;
        }

        context.time.value = Math.round((Date.now() - context.startTime.value) / 1000);
        const words: number = context.typed.value.length / 5;
        context.speed.value = context.time.value > 0 ? Math.round((words / context.time.value) * 60) : 0;

        scrollToCurrentChar(context.textContainer.value, context.typed.value.length);
    };

    return { handleTypingInput };
};

export const useCurrentWord = (text: Ref<string>, typed: Ref<string>): Record<string, ComputedRef<boolean[]>> => {
    const currentTypingUnit: ComputedRef<TypingUnit | null> = computed(
        (): TypingUnit | null => getCurrentTypingUnit(text.value, typed.value.length),
    );

    const isCurrentWord: ComputedRef<boolean[]> = computed((): boolean[] => {
        const arr: boolean[] = Array(text.value.length).fill(false) as boolean[];

        if (!currentTypingUnit.value) { return arr; }

        for (let i: number = currentTypingUnit.value.start; i <= currentTypingUnit.value.end; i++) {
            arr[i] = true;
        }

        return arr;
    });

    return { isCurrentWord };
};

export const useProgress = (text: Ref<string>, typed: Ref<string>, isCompleted: Ref<boolean>): Record<string, ComputedRef<number>> => {
    const progress: ComputedRef<number> = computed((): number => {
        if (isCompleted.value) { return 100; }

        return text.value.length ? Math.floor((typed.value.length / text.value.length) * 100) : 0;
    });

    return { progress };
};
