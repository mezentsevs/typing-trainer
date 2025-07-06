import { ComputedRef, Ref } from 'vue';

export default interface TypingState {
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
