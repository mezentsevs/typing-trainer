import EnLanguage from '@/languages/EnLanguage';
import RuLanguage from '@/languages/RuLanguage';
import type Language from '@/languages/contracts/Language';
import type UIKitSelectOption from '@/interfaces/uikit/UIKitSelectOption';

class LanguageRegistry {
    private languages: Record<string, Language> = {};

    public constructor(languages: Language[]) {
        languages.forEach(language => {
            this.languages[language.getCode()] = language;
        });
    }

    public get(code: string): Language | undefined {
        return this.languages[code];
    }

    public getSupportedOrDefault(code: string): Language {
        return this.languages[code] ?? this.languages[EnLanguage.CODE];
    }

    public getSupportedCodes(): string[] {
        return Object.keys(this.languages);
    }

    public getAllLanguages(): Language[] {
        return Object.values(this.languages);
    }

    public getSelectOptions(): UIKitSelectOption[] {
        return this.getAllLanguages().map(language => ({
            label: language.getLabel(),
            value: language.getCode(),
        }));
    }
}

export const languageRegistry: LanguageRegistry = new LanguageRegistry([
    new EnLanguage(),
    new RuLanguage(),
]);

export default languageRegistry;
