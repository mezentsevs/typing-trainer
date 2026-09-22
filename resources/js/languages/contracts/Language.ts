import type { KeyboardLayout } from '@/types/KeyboardTypes';

export default abstract class Language {
    public abstract getCode(): string;

    public abstract getLabel(): string;

    public abstract getKeyboardLayout(): KeyboardLayout;

    public getDeadKeyMap(): Record<string, string[]> {
        return {};
    }
}
