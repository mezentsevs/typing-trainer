import type { KeyboardLayout } from '@/types/KeyboardTypes';

export default abstract class Language {
    public static readonly CODE: string = '';

    public getCode(): string {
        return (this.constructor as typeof Language).CODE;
    }

    public abstract getLabel(): string;

    public abstract getKeyboardLayout(): KeyboardLayout;

    public getDeadKeyMap(): Record<string, string[]> {
        return {};
    }
}
