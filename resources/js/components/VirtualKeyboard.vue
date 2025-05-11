<template>
    <div class="relative">
        <div
            v-if="isMinimized"
            class="keyboard-preview flex justify-center items-center gap-2 max-w-32 mx-auto my-4 p-2 bg-gray-50 rounded-lg cursor-pointer"
            @click="toggleKeyboard"
        >
            <VirtualKeyboardIcon class="h-6 w-6 fill-gray-500 shrink-0" />
            <span class="text-gray-500 text-sm font-medium">Keyboard</span>
        </div>

        <div
            v-else
            class="keyboard flex flex-col gap-2 p-4 cursor-pointer"
            style="max-width: 680px; margin: 0 auto;"
            @click="toggleKeyboard"
        >
            <div
                v-for="(row, rowIndex) in keyboardLayout"
                :key="rowIndex"
                class="flex gap-1"
                style="justify-content: space-between;"
            >
                <template v-if="rowIndex === 0">
                    <button
                        v-for="key in row"
                        :key="key.value"
                        :class="[
                            'p-2 border rounded text-center relative',
                            isHighlighted(key.value, key.zone) || isHighlighted(key.special, key.zone) ? 'bg-green-500 text-white' : 'bg-gray-200',
                            key.width ? `w-${key.width}` : 'w-10',
                            key.value === 'backspace' ? 'text-sm' : ''
                        ]"
                        :style="{ minWidth: key.width ? `${key.width}px` : '40px' }"
                    >
                        <span class="block">{{ key.display }}</span>
                        <span
                            v-if="key.special"
                            class="absolute text-xs"
                            :class="key.specialPosition === KeyboardSpecialPositionEnum.TopLeft ? 'top-0 left-1' : 'top-0 right-1'"
                        >
                            {{ key.special }}
                        </span>
                    </button>
                </template>
                <template v-else-if="rowIndex === 4">
                    <button
                        :key="row[0].value"
                        :class="[
                            'p-2 border rounded text-center relative',
                            isHighlighted(row[0].value, row[0].zone) ? 'bg-green-500 text-white' : 'bg-gray-200',
                            row[0].width ? `w-${row[0].width}` : 'w-10'
                        ]"
                        :style="{ minWidth: row[0].width ? `${row[0].width}px` : '40px' }"
                    >
                        <span class="block">{{ row[0].display }}</span>
                    </button>
                    <div class="flex gap-1">
                        <button
                            v-for="key in row.slice(1, 4)"
                            :key="key.value"
                            :class="[
                                'p-2 border rounded text-center relative',
                                isHighlighted(key.value, key.zone) ? 'bg-green-500 text-white' : 'bg-gray-200',
                                key.width ? `w-${key.width}` : 'w-10'
                            ]"
                            :style="{ minWidth: key.width ? `${key.width}px` : '40px' }"
                        >
                            <span class="block">{{ key.display }}</span>
                        </button>
                    </div>
                    <button
                        :key="row[4].value"
                        :class="[
                            'p-2 border rounded text-center relative',
                            isHighlighted(row[4].value, row[4].zone) ? 'bg-green-500 text-white' : 'bg-gray-200',
                            row[4].width ? `w-${row[4].width}` : 'w-10'
                        ]"
                        :style="{ minWidth: row[4].width ? `${row[4].width}px` : '40px' }"
                    >
                        <span class="block">{{ row[4].display }}</span>
                    </button>
                </template>
                <template v-else>
                    <button
                        v-for="key in row"
                        :key="key.value"
                        :class="[
                            'p-2 border rounded text-center relative',
                            isHighlighted(key.value, key.zone) || isHighlighted(key.special, key.zone) ? 'bg-green-500 text-white' : 'bg-gray-200',
                            key.width ? `w-${key.width}` : 'w-10'
                        ]"
                        :style="{ minWidth: key.width ? `${key.width}px` : '40px' }"
                    >
                        <span class="block">{{ key.display }}</span>
                        <span
                            v-if="key.special"
                            class="absolute text-xs"
                            :class="key.specialPosition === KeyboardSpecialPositionEnum.TopLeft ? 'top-0 left-1' : 'top-0 right-1'"
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
import VirtualKeyboardIcon from '@/icons/VirtualKeyboardIcon.vue';
import { KeyboardSpecialPositionEnum, KeyboardZoneEnum } from '@/enums/KeyboardEnums';
import { KeyboardSpecialPositionType, KeyboardZoneType } from '@/types/KeyboardTypes';
import { computed, ref } from 'vue';

const props = defineProps<{
    language: 'en' | 'ru';
    typed: string;
    text: string;
    isMinimized?: boolean;
}>();

const isMinimized = ref(props.isMinimized ?? false);

const keyboardLayouts: Record<'en' | 'ru', { value: string; display: string; special?: string; specialPosition?: KeyboardSpecialPositionType; width?: number; zone?: KeyboardZoneType }[][]> = {
    en: [
        [
            { value: '`', display: '`', special: '~', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: '1', display: '1', special: '!', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: '2', display: '2', special: '@', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: '3', display: '3', special: '#', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: '4', display: '4', special: '$', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: '5', display: '5', special: '%', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: '6', display: '6', special: '^', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: '7', display: '7', special: '&', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: '8', display: '8', special: '*', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: '9', display: '9', special: '(', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: '0', display: '0', special: ')', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: '-', display: '-', special: '_', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: '=', display: '=', special: '+', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'backspace', display: 'Backspace', width: 80, zone: KeyboardZoneEnum.Right }
        ],
        [
            { value: 'tab', display: 'Tab', width: 60, zone: KeyboardZoneEnum.Left },
            { value: 'q', display: 'q', special: 'Q', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'w', display: 'w', special: 'W', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'e', display: 'e', special: 'E', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'r', display: 'r', special: 'R', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 't', display: 't', special: 'T', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'y', display: 'y', special: 'Y', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'u', display: 'u', special: 'U', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'i', display: 'i', special: 'I', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'o', display: 'o', special: 'O', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'p', display: 'p', special: 'P', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: '[', display: '[', special: '{', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: ']', display: ']', special: '}', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: '\\', display: '\\', special: '|', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right }
        ],
        [
            { value: 'capslock', display: 'Caps', width: 70, zone: KeyboardZoneEnum.Left },
            { value: 'a', display: 'a', special: 'A', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 's', display: 's', special: 'S', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'd', display: 'd', special: 'D', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'f', display: 'f', special: 'F', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'g', display: 'g', special: 'G', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'h', display: 'h', special: 'H', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'j', display: 'j', special: 'J', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'k', display: 'k', special: 'K', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'l', display: 'l', special: 'L', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: ';', display: ';', special: ':', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: '\'', display: '\'', special: '"', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'enter', display: 'Enter', width: 90, zone: KeyboardZoneEnum.Right }
        ],
        [
            { value: 'shift', display: 'Shift', width: 90, zone: KeyboardZoneEnum.Left },
            { value: 'z', display: 'z', special: 'Z', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'x', display: 'x', special: 'X', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'c', display: 'c', special: 'C', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'v', display: 'v', special: 'V', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'b', display: 'b', special: 'B', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'n', display: 'n', special: 'N', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'm', display: 'm', special: 'M', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: ',', display: ',', special: '<', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: '.', display: '.', special: '>', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: '/', display: '/', special: '?', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'shift', display: 'Shift', width: 110, zone: KeyboardZoneEnum.Right }
        ],
        [
            { value: 'ctrl', display: 'Ctrl', width: 50, zone: KeyboardZoneEnum.Left },
            { value: 'alt', display: 'Alt', width: 50, zone: KeyboardZoneEnum.Left },
            { value: ' ', display: 'Space', width: 250 },
            { value: 'alt', display: 'Alt', width: 50, zone: KeyboardZoneEnum.Right },
            { value: 'ctrl', display: 'Ctrl', width: 50, zone: KeyboardZoneEnum.Right }
        ]
    ],
    ru: [
        [
            { value: 'ё', display: 'ё', special: 'Ё', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: '1', display: '1', special: '!', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: '2', display: '2', special: '"', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: '3', display: '3', special: '№', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: '4', display: '4', special: ';', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: '5', display: '5', special: '%', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: '6', display: '6', special: ':', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: '7', display: '7', special: '?', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: '8', display: '8', special: '*', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: '9', display: '9', special: '(', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: '0', display: '0', special: ')', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: '-', display: '-', special: '_', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: '=', display: '=', special: '+', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'backspace', display: 'Backspace', width: 80, zone: KeyboardZoneEnum.Right }
        ],
        [
            { value: 'tab', display: 'Tab', width: 60, zone: KeyboardZoneEnum.Left },
            { value: 'й', display: 'й', special: 'Й', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'ц', display: 'ц', special: 'Ц', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'у', display: 'у', special: 'У', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'к', display: 'к', special: 'К', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'е', display: 'е', special: 'Е', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'н', display: 'н', special: 'Н', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'г', display: 'г', special: 'Г', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'ш', display: 'ш', special: 'Ш', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'щ', display: 'щ', special: 'Щ', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'з', display: 'з', special: 'З', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'х', display: 'х', special: 'Х', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'ъ', display: 'ъ', special: 'Ъ', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: '/', display: '/', special: '|', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right }
        ],
        [
            { value: 'capslock', display: 'Caps', width: 70, zone: KeyboardZoneEnum.Left },
            { value: 'ф', display: 'ф', special: 'Ф', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'ы', display: 'ы', special: 'Ы', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'в', display: 'в', special: 'В', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'а', display: 'а', special: 'А', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'п', display: 'п', special: 'П', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'р', display: 'р', special: 'Р', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'о', display: 'о', special: 'О', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'л', display: 'л', special: 'Л', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'д', display: 'д', special: 'Д', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'ж', display: 'ж', special: 'Ж', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'э', display: 'э', special: 'Э', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'enter', display: 'Enter', width: 90, zone: KeyboardZoneEnum.Right }
        ],
        [
            { value: 'shift', display: 'Shift', width: 90, zone: KeyboardZoneEnum.Left },
            { value: 'я', display: 'я', special: 'Я', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'ч', display: 'ч', special: 'Ч', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'с', display: 'с', special: 'С', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'м', display: 'м', special: 'М', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'и', display: 'и', special: 'И', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Left },
            { value: 'т', display: 'т', special: 'Т', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'ь', display: 'ь', special: 'Ь', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'б', display: 'б', special: 'Б', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'ю', display: 'ю', special: 'Ю', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: '.', display: '.', special: ',', specialPosition: KeyboardSpecialPositionEnum.TopLeft, zone: KeyboardZoneEnum.Right },
            { value: 'shift', display: 'Shift', width: 110, zone: KeyboardZoneEnum.Right }
        ],
        [
            { value: 'ctrl', display: 'Ctrl', width: 50, zone: KeyboardZoneEnum.Left },
            { value: 'alt', display: 'Alt', width: 50, zone: KeyboardZoneEnum.Left },
            { value: ' ', display: 'Space', width: 250 },
            { value: 'alt', display: 'Alt', width: 50, zone: KeyboardZoneEnum.Right },
            { value: 'ctrl', display: 'Ctrl', width: 50, zone: KeyboardZoneEnum.Right }
        ]
    ]
};

const keyboardLayout = computed(() => keyboardLayouts[props.language]);

const nextChar = computed(() => props.typed.length < props.text.length ? props.text[props.typed.length] : '');

const toggleKeyboard = () => isMinimized.value = !isMinimized.value;

const getOppositeZone = (): KeyboardZoneType => {
    const keyZone = keyboardLayout.value.flat().find(k =>
        k.value === nextChar.value ||
        (k.special && k.special === nextChar.value) ||
        k.value.toLowerCase() === nextChar.value.toLowerCase() ||
        (k.special && k.special.toLowerCase() === nextChar.value.toLowerCase())
    )?.zone;

    return keyZone === KeyboardZoneEnum.Left ? KeyboardZoneEnum.Right : KeyboardZoneEnum.Left;
};

const isHighlighted = (keyValue: string | undefined, zone?: KeyboardZoneType) => {
    if (!keyValue) { return false; }
    if (keyValue === ' ') { return nextChar.value === ' '; }
    if (keyValue === 'enter') { return nextChar.value === '\n'; }

    const isUpperOrSpecial = nextChar.value.match(/[A-ZА-ЯЁ~!@#$%^&*()_+{}|:"<>?]/);
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
