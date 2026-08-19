import { SpecialPosition, Zone } from '@/enums/KeyboardEnums';
import Language from '@/languages/contracts/Language';
import type { KeyboardLayout } from '@/types/KeyboardTypes';

export default class RuLanguage extends Language {
    public static readonly CODE: string = 'ru';

    public getCode(): string {
        return RuLanguage.CODE;
    }

    public getLabel(): string {
        return 'Russian';
    }

    public getKeyboardLayout(): KeyboardLayout {
        return [
            [
                {
                    value: 'ё',
                    display: 'ё',
                    special: 'Ё',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Left,
                },
                {
                    value: '1',
                    display: '1',
                    special: '!',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Left,
                },
                {
                    value: '2',
                    display: '2',
                    special: '"',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Left,
                },
                {
                    value: '3',
                    display: '3',
                    special: '№',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Left,
                },
                {
                    value: '4',
                    display: '4',
                    special: ';',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Left,
                },
                {
                    value: '5',
                    display: '5',
                    special: '%',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Left,
                },
                {
                    value: '6',
                    display: '6',
                    special: ':',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Right,
                },
                {
                    value: '7',
                    display: '7',
                    special: '?',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Right,
                },
                {
                    value: '8',
                    display: '8',
                    special: '*',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Right,
                },
                {
                    value: '9',
                    display: '9',
                    special: '(',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Right,
                },
                {
                    value: '0',
                    display: '0',
                    special: ')',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Right,
                },
                {
                    value: '-',
                    display: '-',
                    special: '_',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Right,
                },
                {
                    value: '=',
                    display: '=',
                    special: '+',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Right,
                },
                { value: 'backspace', display: 'Backspace', width: 76, zone: Zone.Right },
            ],
            [
                { value: 'tab', display: 'Tab', width: 60, zone: Zone.Left },
                {
                    value: 'й',
                    display: 'й',
                    special: 'Й',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Left,
                },
                {
                    value: 'ц',
                    display: 'ц',
                    special: 'Ц',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Left,
                },
                {
                    value: 'у',
                    display: 'у',
                    special: 'У',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Left,
                },
                {
                    value: 'к',
                    display: 'к',
                    special: 'К',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Left,
                },
                {
                    value: 'е',
                    display: 'е',
                    special: 'Е',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Left,
                },
                {
                    value: 'н',
                    display: 'н',
                    special: 'Н',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Right,
                },
                {
                    value: 'г',
                    display: 'г',
                    special: 'Г',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Right,
                },
                {
                    value: 'ш',
                    display: 'ш',
                    special: 'Ш',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Right,
                },
                {
                    value: 'щ',
                    display: 'щ',
                    special: 'Щ',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Right,
                },
                {
                    value: 'з',
                    display: 'з',
                    special: 'З',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Right,
                },
                {
                    value: 'х',
                    display: 'х',
                    special: 'Х',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Right,
                },
                {
                    value: 'ъ',
                    display: 'ъ',
                    special: 'Ъ',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Right,
                },
                {
                    value: '\\',
                    display: '\\',
                    special: '/',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Right,
                },
            ],
            [
                { value: 'capslock', display: 'Caps', width: 70, zone: Zone.Left },
                {
                    value: 'ф',
                    display: 'ф',
                    special: 'Ф',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Left,
                },
                {
                    value: 'ы',
                    display: 'ы',
                    special: 'Ы',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Left,
                },
                {
                    value: 'в',
                    display: 'в',
                    special: 'В',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Left,
                },
                {
                    value: 'а',
                    display: 'а',
                    special: 'А',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Left,
                },
                {
                    value: 'п',
                    display: 'п',
                    special: 'П',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Left,
                },
                {
                    value: 'р',
                    display: 'р',
                    special: 'Р',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Right,
                },
                {
                    value: 'о',
                    display: 'о',
                    special: 'О',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Right,
                },
                {
                    value: 'л',
                    display: 'л',
                    special: 'Л',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Right,
                },
                {
                    value: 'д',
                    display: 'д',
                    special: 'Д',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Right,
                },
                {
                    value: 'ж',
                    display: 'ж',
                    special: 'Ж',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Right,
                },
                {
                    value: 'э',
                    display: 'э',
                    special: 'Э',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Right,
                },
                { value: 'enter', display: 'Enter', width: 90, zone: Zone.Right },
            ],
            [
                { value: 'shift', display: 'Shift', width: 90, zone: Zone.Left },
                {
                    value: 'я',
                    display: 'я',
                    special: 'Я',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Left,
                },
                {
                    value: 'ч',
                    display: 'ч',
                    special: 'Ч',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Left,
                },
                {
                    value: 'с',
                    display: 'с',
                    special: 'С',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Left,
                },
                {
                    value: 'м',
                    display: 'м',
                    special: 'М',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Left,
                },
                {
                    value: 'и',
                    display: 'и',
                    special: 'И',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Left,
                },
                {
                    value: 'т',
                    display: 'т',
                    special: 'Т',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Right,
                },
                {
                    value: 'ь',
                    display: 'ь',
                    special: 'Ь',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Right,
                },
                {
                    value: 'б',
                    display: 'б',
                    special: 'Б',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Right,
                },
                {
                    value: 'ю',
                    display: 'ю',
                    special: 'Ю',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Right,
                },
                {
                    value: '.',
                    display: '.',
                    special: ',',
                    specialPosition: SpecialPosition.TopLeft,
                    zone: Zone.Right,
                },
                { value: 'shift', display: 'Shift', width: 110, zone: Zone.Right },
            ],
            [
                { value: 'ctrl', display: 'Ctrl', width: 50, zone: Zone.Left },
                { value: 'alt', display: 'Alt', width: 50, zone: Zone.Left },
                { value: ' ', display: 'Space', width: 250 },
                { value: 'alt', display: 'Alt', width: 50, zone: Zone.Right },
                { value: 'ctrl', display: 'Ctrl', width: 50, zone: Zone.Right },
            ],
        ];
    }

    public getUpperOrSpecialRegex(): RegExp {
        return /[А-ЯЁ!"№;%:?*()_+/,]/;
    }
}
