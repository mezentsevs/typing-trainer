import type { KeyboardLayout } from '@/types/KeyboardTypes';

export default abstract class Language {
    public static readonly CODE: string = '';
    public static readonly LABEL: string = '';

    public getCode(): string {
        return this._getConstructor().CODE;
    }

    public getLabel(): string {
        return this._getConstructor().LABEL;
    }

    public abstract getKeyboardLayout(): KeyboardLayout;

    public getDeadKeyMap(): Record<string, string[]> {
        return {};
    }

    private _getConstructor(): typeof Language {
        return this.constructor as typeof Language;
    }
}
