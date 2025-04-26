<template>
    <div class="relative">
        <!-- Keyboard Preview -->
        <div
            v-if="isMinimized"
            class="keyboard-preview flex justify-center items-center gap-2 p-2 bg-gray-50 rounded-lg cursor-pointer my-4 mx-auto"
            style="max-width: 200px;"
            @click="toggleKeyboard"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 text-gray-500"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M13 10V3L4 14h7v7l9-11h-7z"
                />
            </svg>
            <span class="text-gray-500 text-sm font-medium">Keyboard</span>
        </div>

        <!-- Keyboard -->
        <div
            v-else
            class="keyboard flex flex-col gap-2 p-4 cursor-pointer"
            style="max-width: 680px; margin: 0 auto;"
            @click="toggleKeyboard"
        >
            <div v-for="(row, rowIndex) in keyboardLayout" :key="rowIndex" class="flex gap-1" style="justify-content: space-between;">
                <template v-if="rowIndex === 0">
                    <!-- First row with Backspace -->
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
                        <span v-if="key.special" class="absolute text-xs" :class="key.specialPosition === 'top-left' ? 'top-0 left-1' : 'top-0 right-1'">
                            {{ key.special }}
                        </span>
                    </button>
                </template>
                <template v-else-if="rowIndex === 4">
                    <!-- Fifth row: Ctrl | (Alt Space Alt) | Ctrl -->
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
                    <!-- Other rows -->
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
                        <span v-if="key.special" class="absolute text-xs" :class="key.specialPosition === 'top-left' ? 'top-0 left-1' : 'top-0 right-1'">
                            {{ key.special }}
                        </span>
                    </button>
                </template>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { computed, ref } from 'vue';

const props = defineProps<{
    language: 'en' | 'ru';
    typed: string;
    text: string;
}>();

const isMinimized = ref(false);

const toggleKeyboard = () => {
    isMinimized.value = !isMinimized.value;
};

const keyboardLayouts: Record<'en' | 'ru', { value: string; display: string; special?: string; specialPosition?: 'top-left' | 'top-right'; width?: number; zone?: 'left' | 'right' }[][]> = {
    en: [
        [
            { value: '`', display: '`', special: '~', specialPosition: 'top-left', zone: 'left' },
            { value: '1', display: '1', special: '!', specialPosition: 'top-left', zone: 'left' },
            { value: '2', display: '2', special: '@', specialPosition: 'top-left', zone: 'left' },
            { value: '3', display: '3', special: '#', specialPosition: 'top-left', zone: 'left' },
            { value: '4', display: '4', special: '$', specialPosition: 'top-left', zone: 'left' },
            { value: '5', display: '5', special: '%', specialPosition: 'top-left', zone: 'left' },
            { value: '6', display: '6', special: '^', specialPosition: 'top-left', zone: 'right' },
            { value: '7', display: '7', special: '&', specialPosition: 'top-left', zone: 'right' },
            { value: '8', display: '8', special: '*', specialPosition: 'top-left', zone: 'right' },
            { value: '9', display: '9', special: '(', specialPosition: 'top-left', zone: 'right' },
            { value: '0', display: '0', special: ')', specialPosition: 'top-left', zone: 'right' },
            { value: '-', display: '-', special: '_', specialPosition: 'top-left', zone: 'right' },
            { value: '=', display: '=', special: '+', specialPosition: 'top-left', zone: 'right' },
            { value: 'backspace', display: 'Backspace', width: 80, zone: 'right' }
        ],
        [
            { value: 'tab', display: 'Tab', width: 60, zone: 'left' },
            { value: 'q', display: 'q', special: 'Q', specialPosition: 'top-left', zone: 'left' },
            { value: 'w', display: 'w', special: 'W', specialPosition: 'top-left', zone: 'left' },
            { value: 'e', display: 'e', special: 'E', specialPosition: 'top-left', zone: 'left' },
            { value: 'r', display: 'r', special: 'R', specialPosition: 'top-left', zone: 'left' },
            { value: 't', display: 't', special: 'T', specialPosition: 'top-left', zone: 'left' },
            { value: 'y', display: 'y', special: 'Y', specialPosition: 'top-left', zone: 'right' },
            { value: 'u', display: 'u', special: 'U', specialPosition: 'top-left', zone: 'right' },
            { value: 'i', display: 'i', special: 'I', specialPosition: 'top-left', zone: 'right' },
            { value: 'o', display: 'o', special: 'O', specialPosition: 'top-left', zone: 'right' },
            { value: 'p', display: 'p', special: 'P', specialPosition: 'top-left', zone: 'right' },
            { value: '[', display: '[', special: '{', specialPosition: 'top-left', zone: 'right' },
            { value: ']', display: ']', special: '}', specialPosition: 'top-left', zone: 'right' },
            { value: '\\', display: '\\', special: '|', specialPosition: 'top-left', zone: 'right' }
        ],
        [
            { value: 'capslock', display: 'Caps', width: 70, zone: 'left' },
            { value: 'a', display: 'a', special: 'A', specialPosition: 'top-left', zone: 'left' },
            { value: 's', display: 's', special: 'S', specialPosition: 'top-left', zone: 'left' },
            { value: 'd', display: 'd', special: 'D', specialPosition: 'top-left', zone: 'left' },
            { value: 'f', display: 'f', special: 'F', specialPosition: 'top-left', zone: 'left' },
            { value: 'g', display: 'g', special: 'G', specialPosition: 'top-left', zone: 'left' },
            { value: 'h', display: 'h', special: 'H', specialPosition: 'top-left', zone: 'right' },
            { value: 'j', display: 'j', special: 'J', specialPosition: 'top-left', zone: 'right' },
            { value: 'k', display: 'k', special: 'K', specialPosition: 'top-left', zone: 'right' },
            { value: 'l', display: 'l', special: 'L', specialPosition: 'top-left', zone: 'right' },
            { value: ';', display: ';', special: ':', specialPosition: 'top-left', zone: 'right' },
            { value: '\'', display: '\'', special: '"', specialPosition: 'top-left', zone: 'right' },
            { value: 'enter', display: 'Enter', width: 90, zone: 'right' }
        ],
        [
            { value: 'shift', display: 'Shift', width: 90, zone: 'left' },
            { value: 'z', display: 'z', special: 'Z', specialPosition: 'top-left', zone: 'left' },
            { value: 'x', display: 'x', special: 'X', specialPosition: 'top-left', zone: 'left' },
            { value: 'c', display: 'c', special: 'C', specialPosition: 'top-left', zone: 'left' },
            { value: 'v', display: 'v', special: 'V', specialPosition: 'top-left', zone: 'left' },
            { value: 'b', display: 'b', special: 'B', specialPosition: 'top-left', zone: 'left' },
            { value: 'n', display: 'n', special: 'N', specialPosition: 'top-left', zone: 'right' },
            { value: 'm', display: 'm', special: 'M', specialPosition: 'top-left', zone: 'right' },
            { value: ',', display: ',', special: '<', specialPosition: 'top-left', zone: 'right' },
            { value: '.', display: '.', special: '>', specialPosition: 'top-left', zone: 'right' },
            { value: '/', display: '/', special: '?', specialPosition: 'top-left', zone: 'right' },
            { value: 'shift', display: 'Shift', width: 110, zone: 'right' }
        ],
        [
            { value: 'ctrl', display: 'Ctrl', width: 50, zone: 'left' },
            { value: 'alt', display: 'Alt', width: 50, zone: 'left' },
            { value: ' ', display: 'Space', width: 250 },
            { value: 'alt', display: 'Alt', width: 50, zone: 'right' },
            { value: 'ctrl', display: 'Ctrl', width: 50, zone: 'right' }
        ]
    ],
    ru: [
        [
            { value: 'ё', display: 'ё', special: 'Ё', specialPosition: 'top-left', zone: 'left' },
            { value: '1', display: '1', special: '!', specialPosition: 'top-left', zone: 'left' },
            { value: '2', display: '2', special: '"', specialPosition: 'top-left', zone: 'left' },
            { value: '3', display: '3', special: '№', specialPosition: 'top-left', zone: 'left' },
            { value: '4', display: '4', special: ';', specialPosition: 'top-left', zone: 'left' },
            { value: '5', display: '5', special: '%', specialPosition: 'top-left', zone: 'left' },
            { value: '6', display: '6', special: ':', specialPosition: 'top-left', zone: 'right' },
            { value: '7', display: '7', special: '?', specialPosition: 'top-left', zone: 'right' },
            { value: '8', display: '8', special: '*', specialPosition: 'top-left', zone: 'right' },
            { value: '9', display: '9', special: '(', specialPosition: 'top-left', zone: 'right' },
            { value: '0', display: '0', special: ')', specialPosition: 'top-left', zone: 'right' },
            { value: '-', display: '-', special: '_', specialPosition: 'top-left', zone: 'right' },
            { value: '=', display: '=', special: '+', specialPosition: 'top-left', zone: 'right' },
            { value: 'backspace', display: 'Backspace', width: 80, zone: 'right' }
        ],
        [
            { value: 'tab', display: 'Tab', width: 60, zone: 'left' },
            { value: 'й', display: 'й', special: 'Й', specialPosition: 'top-left', zone: 'left' },
            { value: 'ц', display: 'ц', special: 'Ц', specialPosition: 'top-left', zone: 'left' },
            { value: 'у', display: 'у', special: 'У', specialPosition: 'top-left', zone: 'left' },
            { value: 'к', display: 'к', special: 'К', specialPosition: 'top-left', zone: 'left' },
            { value: 'е', display: 'е', special: 'Е', specialPosition: 'top-left', zone: 'left' },
            { value: 'н', display: 'н', special: 'Н', specialPosition: 'top-left', zone: 'right' },
            { value: 'г', display: 'г', special: 'Г', specialPosition: 'top-left', zone: 'right' },
            { value: 'ш', display: 'ш', special: 'Ш', specialPosition: 'top-left', zone: 'right' },
            { value: 'щ', display: 'щ', special: 'Щ', specialPosition: 'top-left', zone: 'right' },
            { value: 'з', display: 'з', special: 'З', specialPosition: 'top-left', zone: 'right' },
            { value: 'х', display: 'х', special: 'Х', specialPosition: 'top-left', zone: 'right' },
            { value: 'ъ', display: 'ъ', special: 'Ъ', specialPosition: 'top-left', zone: 'right' },
            { value: '/', display: '/', special: '|', specialPosition: 'top-left', zone: 'right' }
        ],
        [
            { value: 'capslock', display: 'Caps', width: 70, zone: 'left' },
            { value: 'ф', display: 'ф', special: 'Ф', specialPosition: 'top-left', zone: 'left' },
            { value: 'ы', display: 'ы', special: 'Ы', specialPosition: 'top-left', zone: 'left' },
            { value: 'в', display: 'в', special: 'В', specialPosition: 'top-left', zone: 'left' },
            { value: 'а', display: 'а', special: 'А', specialPosition: 'top-left', zone: 'left' },
            { value: 'п', display: 'п', special: 'П', specialPosition: 'top-left', zone: 'left' },
            { value: 'р', display: 'р', special: 'Р', specialPosition: 'top-left', zone: 'right' },
            { value: 'о', display: 'о', special: 'О', specialPosition: 'top-left', zone: 'right' },
            { value: 'л', display: 'л', special: 'Л', specialPosition: 'top-left', zone: 'right' },
            { value: 'д', display: 'д', special: 'Д', specialPosition: 'top-left', zone: 'right' },
            { value: 'ж', display: 'ж', special: 'Ж', specialPosition: 'top-left', zone: 'right' },
            { value: 'э', display: 'э', special: 'Э', specialPosition: 'top-left', zone: 'right' },
            { value: 'enter', display: 'Enter', width: 90, zone: 'right' }
        ],
        [
            { value: 'shift', display: 'Shift', width: 90, zone: 'left' },
            { value: 'я', display: 'я', special: 'Я', specialPosition: 'top-left', zone: 'left' },
            { value: 'ч', display: 'ч', special: 'Ч', specialPosition: 'top-left', zone: 'left' },
            { value: 'с', display: 'с', special: 'С', specialPosition: 'top-left', zone: 'left' },
            { value: 'м', display: 'м', special: 'М', specialPosition: 'top-left', zone: 'left' },
            { value: 'и', display: 'и', special: 'И', specialPosition: 'top-left', zone: 'left' },
            { value: 'т', display: 'т', special: 'Т', specialPosition: 'top-left', zone: 'right' },
            { value: 'ь', display: 'ь', special: 'Ь', specialPosition: 'top-left', zone: 'right' },
            { value: 'б', display: 'б', special: 'Б', specialPosition: 'top-left', zone: 'right' },
            { value: 'ю', display: 'ю', special: 'Ю', specialPosition: 'top-left', zone: 'right' },
            { value: '.', display: '.', special: ',', specialPosition: 'top-left', zone: 'right' },
            { value: 'shift', display: 'Shift', width: 110, zone: 'right' }
        ],
        [
            { value: 'ctrl', display: 'Ctrl', width: 50, zone: 'left' },
            { value: 'alt', display: 'Alt', width: 50, zone: 'left' },
            { value: ' ', display: 'Space', width: 250 },
            { value: 'alt', display: 'Alt', width: 50, zone: 'right' },
            { value: 'ctrl', display: 'Ctrl', width: 50, zone: 'right' }
        ]
    ]
};

const keyboardLayout = computed(() => keyboardLayouts[props.language]);

const nextChar = computed(() => {
    return props.typed.length < props.text.length ? props.text[props.typed.length] : '';
});

const isHighlighted = (keyValue: string | undefined, zone?: 'left' | 'right') => {
    if (!keyValue) return false;
    if (keyValue === ' ') return nextChar.value === ' ';
    if (keyValue === 'enter') return nextChar.value === '\n';

    const isUpperOrSpecial = nextChar.value.match(/[A-ZА-ЯЁ~!@#$%^&*()_+{}|:"<>?]/);
    const isControlChar = nextChar.value !== '\n' && nextChar.value.match(/[\x00-\x1F\x7F]/);

    if (keyValue === 'shift') {
        if (!isUpperOrSpecial) return false;
        const keyZone = keyboardLayout.value.flat().find(k =>
            k.value === nextChar.value ||
            (k.special && k.special === nextChar.value) ||
            k.value.toLowerCase() === nextChar.value.toLowerCase() ||
            (k.special && k.special.toLowerCase() === nextChar.value.toLowerCase())
        )?.zone;
        return keyZone === 'left' ? zone === 'right' : zone === 'left';
    }

    if (['ctrl', 'alt', 'capslock'].includes(keyValue)) {
        if (!isControlChar) return false;
        const keyZone = keyboardLayout.value.flat().find(k =>
            k.value === nextChar.value ||
            (k.special && k.special === nextChar.value) ||
            k.value.toLowerCase() === nextChar.value.toLowerCase() ||
            (k.special && k.special.toLowerCase() === nextChar.value.toLowerCase())
        )?.zone;
        return keyZone === 'left' ? zone === 'right' : zone === 'left';
    }

    return nextChar.value === keyValue || nextChar.value.toLowerCase() === keyValue.toLowerCase();
};
</script>
