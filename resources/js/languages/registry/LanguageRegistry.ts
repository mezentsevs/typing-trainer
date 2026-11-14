import DeLanguage from '@/languages/DeLanguage';
import EnLanguage from '@/languages/EnLanguage';
import EsLanguage from '@/languages/EsLanguage';
import FrLanguage from '@/languages/FrLanguage';
import IdLanguage from '@/languages/IdLanguage';
import ItLanguage from '@/languages/ItLanguage';
import PlLanguage from '@/languages/PlLanguage';
import PtLanguage from '@/languages/PtLanguage';
import RuLanguage from '@/languages/RuLanguage';
import TrLanguage from '@/languages/TrLanguage';
import type Language from '@/languages/contracts/Language';
import type UIKitSelectOption from '@/interfaces/uikit/UIKitSelectOption';

class LanguageRegistry {
    private _languages: Record<string, Language> = {};

    public constructor(languages: Language[]) {
        languages.forEach(language => {
            this._languages[language.getCode()] = language;
        });
    }

    public get(code: string): Language | undefined {
        return this._languages[code];
    }

    public getSupportedOrDefault(code: string): Language {
        return this._languages[code] ?? this._languages[EnLanguage.CODE];
    }

    public getSupportedCodes(): string[] {
        return Object.keys(this._languages);
    }

    public getAllLanguages(): Language[] {
        return Object.values(this._languages);
    }

    public getSelectOptions(): UIKitSelectOption[] {
        return this.getAllLanguages().map(language => ({
            label: language.getLabel(),
            value: language.getCode(),
        }));
    }
}

export const languageRegistry: LanguageRegistry = new LanguageRegistry([
    new DeLanguage(),
    new EnLanguage(),
    new EsLanguage(),
    new FrLanguage(),
    new IdLanguage(),
    new ItLanguage(),
    new PlLanguage(),
    new PtLanguage(),
    new RuLanguage(),
    new TrLanguage(),
]);

export default languageRegistry;
