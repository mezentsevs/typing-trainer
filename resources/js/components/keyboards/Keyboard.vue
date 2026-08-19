<template>
    <transition
        mode="out-in"
        enter-active-class="transition-all duration-100 ease-out"
        enter-from-class="opacity-0 scale-95"
        leave-active-class="transition-all duration-100 ease-out"
        leave-to-class="opacity-0 scale-95">
        <div v-if="isMinimized" key="minimized" class="group relative w-32 mx-auto">
            <Tooltip text="Show Keyboard" />
            <button
                class="keyboard-preview-button w-full px-2 py-1 flex justify-center items-center gap-2 border border-opacity-50 border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 active:bg-gray-50 dark:active:bg-gray-900 text-gray-500 dark:text-gray-300 text-sm font-medium select-none cursor-pointer rounded-md shadow-sm"
                @click="toggleKeyboard">
                <KeyboardIcon class="w-6 h-6 shrink-0 fill-gray-500 dark:fill-gray-300" />
                Keyboard
            </button>
        </div>

        <section
            v-else
            key="expanded"
            class="keyboard max-w-[680px] mx-auto flex flex-col gap-2 px-4 select-none cursor-pointer"
            @click="toggleKeyboard">
            <div
                v-for="(row, rowIndex) in layout"
                :key="rowIndex"
                class="flex justify-between gap-1">
                <template v-if="rowIndex === 0">
                    <button
                        v-for="key in row"
                        :key="key.value"
                        :class="[
                            COMMON_BUTTON_CLASS,
                            isHighlighted(key.value, key.zone) ||
                            isHighlighted(key.special, key.zone)
                                ? HIGHLIGHTED_BUTTON_CLASS
                                : NORMAL_BUTTON_CLASS,
                            key.width ? `w-${key.width}` : 'w-10',
                            key.value === 'backspace' ? 'text-sm px-1' : '',
                        ]"
                        :style="getKeyStyle(key)">
                        <span class="block">{{ key.display }}</span>
                        <span
                            v-if="key.special"
                            class="absolute text-xs"
                            :class="
                                key.specialPosition === SpecialPosition.TopLeft
                                    ? 'top-0 left-1'
                                    : 'top-0 right-1'
                            ">
                            {{ key.special }}
                        </span>
                    </button>
                </template>
                <template v-else-if="rowIndex === 4">
                    <button
                        :key="row[0].value"
                        :class="[
                            COMMON_BUTTON_CLASS,
                            isHighlighted(row[0].value, row[0].zone)
                                ? HIGHLIGHTED_BUTTON_CLASS
                                : NORMAL_BUTTON_CLASS,
                            row[0].width ? `w-${row[0].width}` : 'w-10',
                        ]"
                        :style="getKeyStyle(row[0])">
                        <span class="block">{{ row[0].display }}</span>
                    </button>
                    <div class="flex gap-1">
                        <button
                            v-for="key in row.slice(1, 4)"
                            :key="key.value"
                            :class="[
                                COMMON_BUTTON_CLASS,
                                isHighlighted(key.value, key.zone)
                                    ? HIGHLIGHTED_BUTTON_CLASS
                                    : NORMAL_BUTTON_CLASS,
                                key.width ? `w-${key.width}` : 'w-10',
                            ]"
                            :style="getKeyStyle(key)">
                            <span class="block">{{ key.display }}</span>
                        </button>
                    </div>
                    <button
                        :key="row[4].value"
                        :class="[
                            COMMON_BUTTON_CLASS,
                            isHighlighted(row[4].value, row[4].zone)
                                ? HIGHLIGHTED_BUTTON_CLASS
                                : NORMAL_BUTTON_CLASS,
                            row[4].width ? `w-${row[4].width}` : 'w-10',
                        ]"
                        :style="getKeyStyle(row[4])">
                        <span class="block">{{ row[4].display }}</span>
                    </button>
                </template>
                <template v-else>
                    <button
                        v-for="key in row"
                        :key="key.value"
                        :class="[
                            COMMON_BUTTON_CLASS,
                            isHighlighted(key.value, key.zone) ||
                            isHighlighted(key.special, key.zone)
                                ? HIGHLIGHTED_BUTTON_CLASS
                                : NORMAL_BUTTON_CLASS,
                            key.width ? `w-${key.width}` : 'w-10',
                        ]"
                        :style="getKeyStyle(key)">
                        <span class="block">{{ key.display }}</span>
                        <span
                            v-if="key.special"
                            class="absolute text-xs"
                            :class="
                                key.specialPosition === SpecialPosition.TopLeft
                                    ? 'top-0 left-1'
                                    : 'top-0 right-1'
                            ">
                            {{ key.special }}
                        </span>
                    </button>
                </template>
            </div>
        </section>
    </transition>
</template>

<script lang="ts" setup>
import { computed, ComputedRef, Ref, ref } from 'vue';
import { SpecialPosition, Zone } from '@/enums/KeyboardEnums';
import KeyboardIcon from '@/components/icons/KeyboardIcon.vue';
import Tooltip from '@/components/uikit/tooltips/Tooltip.vue';
import type { KeyboardLayout } from '@/types/KeyboardTypes';
import type KeyboardKey from '@/interfaces/KeyboardKey';

const props = defineProps<{
    isMinimized?: boolean;
    layout: KeyboardLayout;
    text: string;
    typed: string;
    upperOrSpecialRegex: RegExp;
}>();

const COMMON_BUTTON_CLASS: string =
    'p-2 border border-opacity-50 border-gray-300 dark:border-gray-700 text-center rounded shadow-sm relative transition-colors duration-150 ease-linear';
const HIGHLIGHTED_BUTTON_CLASS: string = 'bg-green-500 text-white dark:text-black';
const NORMAL_BUTTON_CLASS: string = 'bg-gray-50 dark:bg-gray-900 dark:text-gray-300';

const isMinimized: Ref<boolean> = ref(props.isMinimized ?? false);

const nextChar: ComputedRef<string> = computed((): string =>
    props.typed.length < props.text.length ? props.text[props.typed.length] : '',
);

const toggleKeyboard = (): void => {
    isMinimized.value = !isMinimized.value;
};

const getKeyStyle = (key: KeyboardKey): Record<string, string> => {
    return { minWidth: key.width ? `${key.width}px` : '40px' };
};

const getOppositeZone = (): Zone | null => {
    const keyZone = props.layout
        .flat()
        .find(
            k =>
                k.value === nextChar.value ||
                (k.special && k.special === nextChar.value) ||
                k.value.toLowerCase() === nextChar.value.toLowerCase() ||
                (k.special && k.special.toLowerCase() === nextChar.value.toLowerCase()),
        )?.zone;

    return keyZone === Zone.Left ? Zone.Right : Zone.Left;
};

const isHighlighted = (keyValue: string | undefined, zone?: Zone | null): boolean => {
    if (!keyValue) {
        return false;
    }
    if (keyValue === ' ') {
        return nextChar.value === ' ';
    }
    if (keyValue === 'enter') {
        return nextChar.value === '\n';
    }

    const isUpperOrSpecial = nextChar.value.match(props.upperOrSpecialRegex);
    const isControlChar = nextChar.value !== '\n' && nextChar.value.match(/[\x00-\x1F\x7F]/);

    if (keyValue === 'shift') {
        if (!isUpperOrSpecial) {
            return false;
        }

        return getOppositeZone() === zone;
    }

    if (['ctrl', 'alt', 'capslock'].includes(keyValue)) {
        if (!isControlChar) {
            return false;
        }

        return getOppositeZone() === zone;
    }

    return nextChar.value === keyValue || nextChar.value.toLowerCase() === keyValue.toLowerCase();
};
</script>
