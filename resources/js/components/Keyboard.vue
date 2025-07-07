<template>
    <div class="relative">
        <div
            v-if="isMinimized"
            class="keyboard-preview max-w-32 mx-auto my-4 p-2 flex justify-center items-center gap-2 border border-opacity-50 border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 hover:bg-white dark:hover:bg-gray-800 active:bg-gray-50 dark:active:bg-gray-900 text-gray-500 dark:text-gray-300 cursor-pointer select-none rounded-lg shadow-sm"
            @click="toggleKeyboard"
        >
            <KeyboardIcon class="w-6 h-6 shrink-0 fill-gray-500 dark:fill-gray-300" />
            <span class="text-sm font-medium">Keyboard</span>
        </div>

        <div
            v-else
            class="keyboard max-w-[680px] mx-auto flex flex-col gap-2 p-4 cursor-pointer"
            @click="toggleKeyboard"
        >
            <div
                v-for="(row, rowIndex) in keyboardLayout"
                :key="rowIndex"
                class="flex justify-between gap-1"
            >
                <template v-if="rowIndex === 0">
                    <button
                        v-for="key in row"
                        :key="key.value"
                        :class="[
                            BUTTON_DEFAULT_CLASS,
                            isHighlighted(key.value, key.zone) || isHighlighted(key.special, key.zone) ? BUTTON_HIGHLIGHTED_CLASS : BUTTON_NORMAL_CLASS,
                            key.width ? `w-${key.width}` : 'w-10',
                            key.value === 'backspace' ? 'text-sm' : ''
                        ]"
                        :style="getKeyStyle(key)"
                    >
                        <span class="block">{{ key.display }}</span>
                        <span
                            v-if="key.special"
                            class="absolute text-xs"
                            :class="key.specialPosition === SpecialPosition.TopLeft ? 'top-0 left-1' : 'top-0 right-1'"
                        >
                            {{ key.special }}
                        </span>
                    </button>
                </template>
                <template v-else-if="rowIndex === 4">
                    <button
                        :key="row[0].value"
                        :class="[
                            BUTTON_DEFAULT_CLASS,
                            isHighlighted(row[0].value, row[0].zone) ? BUTTON_HIGHLIGHTED_CLASS : BUTTON_NORMAL_CLASS,
                            row[0].width ? `w-${row[0].width}` : 'w-10'
                        ]"
                        :style="getKeyStyle(row[0])"
                    >
                        <span class="block">{{ row[0].display }}</span>
                    </button>
                    <div class="flex gap-1">
                        <button
                            v-for="key in row.slice(1, 4)"
                            :key="key.value"
                            :class="[
                                BUTTON_DEFAULT_CLASS,
                                isHighlighted(key.value, key.zone) ? BUTTON_HIGHLIGHTED_CLASS : BUTTON_NORMAL_CLASS,
                                key.width ? `w-${key.width}` : 'w-10'
                            ]"
                            :style="getKeyStyle(key)"
                        >
                            <span class="block">{{ key.display }}</span>
                        </button>
                    </div>
                    <button
                        :key="row[4].value"
                        :class="[
                            BUTTON_DEFAULT_CLASS,
                            isHighlighted(row[4].value, row[4].zone) ? BUTTON_HIGHLIGHTED_CLASS : BUTTON_NORMAL_CLASS,
                            row[4].width ? `w-${row[4].width}` : 'w-10'
                        ]"
                        :style="getKeyStyle(row[4])"
                    >
                        <span class="block">{{ row[4].display }}</span>
                    </button>
                </template>
                <template v-else>
                    <button
                        v-for="key in row"
                        :key="key.value"
                        :class="[
                            BUTTON_DEFAULT_CLASS,
                            isHighlighted(key.value, key.zone) || isHighlighted(key.special, key.zone) ? BUTTON_HIGHLIGHTED_CLASS : BUTTON_NORMAL_CLASS,
                            key.width ? `w-${key.width}` : 'w-10'
                        ]"
                        :style="getKeyStyle(key)"
                    >
                        <span class="block">{{ key.display }}</span>
                        <span
                            v-if="key.special"
                            class="absolute text-xs"
                            :class="key.specialPosition === SpecialPosition.TopLeft ? 'top-0 left-1' : 'top-0 right-1'"
                        >
                            {{ key.special }}
                        </span>
                    </button>
                </template>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import KeyboardIcon from '@/components/icons/KeyboardIcon.vue';
import KeyboardKey from '@/interfaces/KeyboardKey';
import { KeyboardLayout } from '@/types/KeyboardTypes';
import { Language, SpecialPosition, Zone } from '@/enums/KeyboardEnums';
import { computed, ComputedRef, Ref, ref } from 'vue';

const props = defineProps<{
    language: Language,
    typed: string,
    text: string,
    isMinimized?: boolean,
}>();

const BUTTON_DEFAULT_CLASS: string = 'p-2 border border-opacity-50 border-gray-300 dark:border-gray-700 text-center rounded shadow-sm relative';
const BUTTON_HIGHLIGHTED_CLASS: string = 'bg-green-500 text-white dark:text-black';
const BUTTON_NORMAL_CLASS: string = 'bg-gray-50 dark:bg-gray-900 dark:text-gray-300';
const KEYBOARD_LAYOUTS: Record<Language, KeyboardLayout> = {
    [Language.En]: [
        [
            { value: '`', display: '`', special: '~', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: '1', display: '1', special: '!', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: '2', display: '2', special: '@', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: '3', display: '3', special: '#', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: '4', display: '4', special: '$', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: '5', display: '5', special: '%', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: '6', display: '6', special: '^', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: '7', display: '7', special: '&', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: '8', display: '8', special: '*', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: '9', display: '9', special: '(', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: '0', display: '0', special: ')', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: '-', display: '-', special: '_', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: '=', display: '=', special: '+', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'backspace', display: 'Backspace', width: 80, zone: Zone.Right }
        ],
        [
            { value: 'tab', display: 'Tab', width: 60, zone: Zone.Left },
            { value: 'q', display: 'q', special: 'Q', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'w', display: 'w', special: 'W', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'e', display: 'e', special: 'E', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'r', display: 'r', special: 'R', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 't', display: 't', special: 'T', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'y', display: 'y', special: 'Y', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'u', display: 'u', special: 'U', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'i', display: 'i', special: 'I', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'o', display: 'o', special: 'O', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'p', display: 'p', special: 'P', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: '[', display: '[', special: '{', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: ']', display: ']', special: '}', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: '\\', display: '\\', special: '|', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right }
        ],
        [
            { value: 'capslock', display: 'Caps', width: 70, zone: Zone.Left },
            { value: 'a', display: 'a', special: 'A', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 's', display: 's', special: 'S', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'd', display: 'd', special: 'D', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'f', display: 'f', special: 'F', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'g', display: 'g', special: 'G', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'h', display: 'h', special: 'H', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'j', display: 'j', special: 'J', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'k', display: 'k', special: 'K', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'l', display: 'l', special: 'L', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: ';', display: ';', special: ':', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: '\'', display: '\'', special: '"', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'enter', display: 'Enter', width: 90, zone: Zone.Right }
        ],
        [
            { value: 'shift', display: 'Shift', width: 90, zone: Zone.Left },
            { value: 'z', display: 'z', special: 'Z', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'x', display: 'x', special: 'X', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'c', display: 'c', special: 'C', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'v', display: 'v', special: 'V', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'b', display: 'b', special: 'B', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'n', display: 'n', special: 'N', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'm', display: 'm', special: 'M', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: ',', display: ',', special: '<', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: '.', display: '.', special: '>', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: '/', display: '/', special: '?', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'shift', display: 'Shift', width: 110, zone: Zone.Right }
        ],
        [
            { value: 'ctrl', display: 'Ctrl', width: 50, zone: Zone.Left },
            { value: 'alt', display: 'Alt', width: 50, zone: Zone.Left },
            { value: ' ', display: 'Space', width: 250 },
            { value: 'alt', display: 'Alt', width: 50, zone: Zone.Right },
            { value: 'ctrl', display: 'Ctrl', width: 50, zone: Zone.Right }
        ]
    ],
    [Language.Ru]: [
        [
            { value: 'ё', display: 'ё', special: 'Ё', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: '1', display: '1', special: '!', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: '2', display: '2', special: '"', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: '3', display: '3', special: '№', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: '4', display: '4', special: ';', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: '5', display: '5', special: '%', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: '6', display: '6', special: ':', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: '7', display: '7', special: '?', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: '8', display: '8', special: '*', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: '9', display: '9', special: '(', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: '0', display: '0', special: ')', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: '-', display: '-', special: '_', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: '=', display: '=', special: '+', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'backspace', display: 'Backspace', width: 80, zone: Zone.Right }
        ],
        [
            { value: 'tab', display: 'Tab', width: 60, zone: Zone.Left },
            { value: 'й', display: 'й', special: 'Й', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'ц', display: 'ц', special: 'Ц', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'у', display: 'у', special: 'У', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'к', display: 'к', special: 'К', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'е', display: 'е', special: 'Е', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'н', display: 'н', special: 'Н', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'г', display: 'г', special: 'Г', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'ш', display: 'ш', special: 'Ш', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'щ', display: 'щ', special: 'Щ', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'з', display: 'з', special: 'З', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'х', display: 'х', special: 'Х', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'ъ', display: 'ъ', special: 'Ъ', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: '\\', display: '\\', special: '/', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right }
        ],
        [
            { value: 'capslock', display: 'Caps', width: 70, zone: Zone.Left },
            { value: 'ф', display: 'ф', special: 'Ф', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'ы', display: 'ы', special: 'Ы', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'в', display: 'в', special: 'В', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'а', display: 'а', special: 'А', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'п', display: 'п', special: 'П', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'р', display: 'р', special: 'Р', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'о', display: 'о', special: 'О', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'л', display: 'л', special: 'Л', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'д', display: 'д', special: 'Д', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'ж', display: 'ж', special: 'Ж', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'э', display: 'э', special: 'Э', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'enter', display: 'Enter', width: 90, zone: Zone.Right }
        ],
        [
            { value: 'shift', display: 'Shift', width: 90, zone: Zone.Left },
            { value: 'я', display: 'я', special: 'Я', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'ч', display: 'ч', special: 'Ч', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'с', display: 'с', special: 'С', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'м', display: 'м', special: 'М', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'и', display: 'и', special: 'И', specialPosition: SpecialPosition.TopLeft, zone: Zone.Left },
            { value: 'т', display: 'т', special: 'Т', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'ь', display: 'ь', special: 'Ь', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'б', display: 'б', special: 'Б', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'ю', display: 'ю', special: 'Ю', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: '.', display: '.', special: ',', specialPosition: SpecialPosition.TopLeft, zone: Zone.Right },
            { value: 'shift', display: 'Shift', width: 110, zone: Zone.Right }
        ],
        [
            { value: 'ctrl', display: 'Ctrl', width: 50, zone: Zone.Left },
            { value: 'alt', display: 'Alt', width: 50, zone: Zone.Left },
            { value: ' ', display: 'Space', width: 250 },
            { value: 'alt', display: 'Alt', width: 50, zone: Zone.Right },
            { value: 'ctrl', display: 'Ctrl', width: 50, zone: Zone.Right }
        ]
    ]
};
const UPPER_OR_SPECIAL_REGEX: Record<Language, RegExp> = {
    [Language.En]: /[A-Z~!@#$%^&*()_+{}|:"<>?]/,
    [Language.Ru]: /[А-ЯЁ!"№;%:?*()_+/,]/,
};
const isMinimized: Ref<boolean> = ref(props.isMinimized ?? false);

const keyboardLayout: ComputedRef<KeyboardLayout> = computed((): KeyboardLayout => KEYBOARD_LAYOUTS[props.language]);

const nextChar: ComputedRef<string> = computed((): string => props.typed.length < props.text.length ? props.text[props.typed.length] : '');

const toggleKeyboard = (): void => { isMinimized.value = !isMinimized.value; };

const getKeyStyle = (key: KeyboardKey): Record<string, string> => {
    return { minWidth: key.width ? `${key.width}px` : '40px' };
};

const getOppositeZone = (): Zone | null => {
    const keyZone = keyboardLayout.value.flat().find(k =>
        k.value === nextChar.value ||
        (k.special && k.special === nextChar.value) ||
        k.value.toLowerCase() === nextChar.value.toLowerCase() ||
        (k.special && k.special.toLowerCase() === nextChar.value.toLowerCase())
    )?.zone;

    return keyZone === Zone.Left ? Zone.Right : Zone.Left;
};

const isHighlighted = (keyValue: string | undefined, zone?: Zone | null): boolean => {
    if (!keyValue) { return false; }
    if (keyValue === ' ') { return nextChar.value === ' '; }
    if (keyValue === 'enter') { return nextChar.value === '\n'; }

    const isUpperOrSpecial = nextChar.value.match(UPPER_OR_SPECIAL_REGEX[props.language]);
    const isControlChar = nextChar.value !== '\n' && nextChar.value.match(/[\x00-\x1F\x7F]/);

    if (keyValue === 'shift') {
        if (!isUpperOrSpecial) { return false; }

        return getOppositeZone() === zone;
    }

    if (['ctrl', 'alt', 'capslock'].includes(keyValue)) {
        if (!isControlChar) { return false; }

        return getOppositeZone() === zone;
    }

    return nextChar.value === keyValue || nextChar.value.toLowerCase() === keyValue.toLowerCase();
};
</script>
