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
            class="keyboard max-w-[720px] mx-auto flex flex-col gap-2 px-4 select-none cursor-pointer"
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
                            KEY_COMMON_CLASS,
                            isKeyHighlighted(key) ? KEY_HIGHLIGHTED_CLASS : KEY_NORMAL_CLASS,
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
                        <span
                            v-if="key.altGr"
                            class="absolute text-xs bottom-0 right-1"
                            :class="
                                key.altGrPosition === SpecialPosition.BottomLeft
                                    ? 'bottom-0 left-1'
                                    : 'bottom-0 right-1'
                            ">
                            {{ key.altGr }}
                        </span>
                        <span v-if="key.altGrShift" class="absolute text-xs bottom-0 left-1">
                            {{ key.altGrShift }}
                        </span>
                    </button>
                </template>
                <template v-else-if="rowIndex === 4">
                    <button
                        :key="row[0].value"
                        :class="[
                            KEY_COMMON_CLASS,
                            isKeyHighlighted(row[0]) ? KEY_HIGHLIGHTED_CLASS : KEY_NORMAL_CLASS,
                        ]"
                        :style="getKeyStyle(row[0])">
                        <span class="block">{{ row[0].display }}</span>
                    </button>
                    <div class="flex gap-1">
                        <button
                            v-for="key in row.slice(1, 4)"
                            :key="key.value"
                            :class="[
                                KEY_COMMON_CLASS,
                                isKeyHighlighted(key) ? KEY_HIGHLIGHTED_CLASS : KEY_NORMAL_CLASS,
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
                            <span
                                v-if="key.altGr"
                                class="absolute text-xs bottom-0 right-1"
                                :class="
                                    key.altGrPosition === SpecialPosition.BottomLeft
                                        ? 'bottom-0 left-1'
                                        : 'bottom-0 right-1'
                                ">
                                {{ key.altGr }}
                            </span>
                            <span v-if="key.altGrShift" class="absolute text-xs bottom-0 left-1">
                                {{ key.altGrShift }}
                            </span>
                        </button>
                    </div>
                    <button
                        :key="row[4].value"
                        :class="[
                            KEY_COMMON_CLASS,
                            isKeyHighlighted(row[4]) ? KEY_HIGHLIGHTED_CLASS : KEY_NORMAL_CLASS,
                        ]"
                        :style="getKeyStyle(row[4])">
                        <span class="block">{{ row[4].display }}</span>
                        <span
                            v-if="row[4].special"
                            class="absolute text-xs"
                            :class="
                                row[4].specialPosition === SpecialPosition.TopLeft
                                    ? 'top-0 left-1'
                                    : 'top-0 right-1'
                            ">
                            {{ row[4].special }}
                        </span>
                        <span
                            v-if="row[4].altGr"
                            class="absolute text-xs bottom-0 right-1"
                            :class="
                                row[4].altGrPosition === SpecialPosition.BottomLeft
                                    ? 'bottom-0 left-1'
                                    : 'bottom-0 right-1'
                            ">
                            {{ row[4].altGr }}
                        </span>
                        <span v-if="row[4].altGrShift" class="absolute text-xs bottom-0 left-1">
                            {{ row[4].altGrShift }}
                        </span>
                    </button>
                </template>
                <template v-else>
                    <button
                        v-for="key in row"
                        :key="key.value"
                        :class="[
                            KEY_COMMON_CLASS,
                            isKeyHighlighted(key) ? KEY_HIGHLIGHTED_CLASS : KEY_NORMAL_CLASS,
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
                        <span
                            v-if="key.altGr"
                            class="absolute text-xs bottom-0 right-1"
                            :class="
                                key.altGrPosition === SpecialPosition.BottomLeft
                                    ? 'bottom-0 left-1'
                                    : 'bottom-0 right-1'
                            ">
                            {{ key.altGr }}
                        </span>
                        <span v-if="key.altGrShift" class="absolute text-xs bottom-0 left-1">
                            {{ key.altGrShift }}
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
    deadKeyMap?: Record<string, string[]>;
}>();

const KEY_COMMON_CLASS: string =
    'p-2 border border-opacity-50 border-gray-300 dark:border-gray-700 text-center rounded shadow-sm relative transition-colors duration-150 ease-linear';
const KEY_HIGHLIGHTED_CLASS: string = 'bg-green-500 text-white dark:text-black';
const KEY_NORMAL_CLASS: string = 'bg-gray-50 dark:bg-gray-900 dark:text-gray-300';

const isMinimized: Ref<boolean> = ref(props.isMinimized ?? false);

const nextChar: ComputedRef<string> = computed((): string =>
    props.typed.length < props.text.length ? props.text[props.typed.length] : '',
);

type KeyLevel = 'value' | 'special' | 'altGrShift' | 'altGr' | 'capsLock';

const KEY_LEVEL_PRIORITY: Record<KeyLevel, number> = {
    value: 0,
    special: 1,
    altGrShift: 2,
    altGr: 3,
    capsLock: 4,
};

const getKeyLevel = (char: string): { key: KeyboardKey; level: KeyLevel } | null => {
    if (!char) return null;

    let best: { key: KeyboardKey; level: KeyLevel } | null = null;

    for (const key of props.layout.flat()) {
        const candidates: [string | undefined, KeyLevel][] = [
            [key.value, 'value'],
            [key.special, 'special'],
            [key.altGrShift, 'altGrShift'],
            [key.altGr, 'altGr'],
            [key.capsLock, 'capsLock'],
        ];

        if (key.altGr && key.altGr.length === 1 && key.altGr.toUpperCase() !== key.altGr) {
            candidates.push([key.altGr.toUpperCase(), 'altGrShift']);
        }

        for (const [value, level] of candidates) {
            if (value !== char) continue;
            if (!best || KEY_LEVEL_PRIORITY[level] < KEY_LEVEL_PRIORITY[best.level]) {
                best = { key, level };
            }
        }
    }

    return best;
};

const deadKeyInfo = computed(() => {
    const sequence = props.deadKeyMap?.[nextChar.value] ?? [];
    if (sequence.length === 0) return null;

    const deadKey = sequence[0];
    const baseChar = sequence[1];
    const deadKeyLevel = getKeyLevel(deadKey);
    const baseCharLevel = getKeyLevel(baseChar);

    return {
        sequence,
        deadKeyLevel,
        baseCharLevel,
        requiresShift: deadKeyLevel?.level === 'special' || baseCharLevel?.level === 'special',
        requiresAltGr:
            deadKeyLevel?.level === 'altGr' ||
            baseCharLevel?.level === 'altGr' ||
            deadKeyLevel?.level === 'altGrShift' ||
            baseCharLevel?.level === 'altGrShift',
    };
});

const currentKeyInfo = computed(() => getKeyLevel(nextChar.value));

const requiredShift = computed(() => {
    if (deadKeyInfo.value) return deadKeyInfo.value.requiresShift;
    return (
        currentKeyInfo.value?.level === 'special' || currentKeyInfo.value?.level === 'altGrShift'
    );
});

const requiredAltGr = computed(() => {
    if (deadKeyInfo.value) return deadKeyInfo.value.requiresAltGr;
    return currentKeyInfo.value?.level === 'altGr' || currentKeyInfo.value?.level === 'altGrShift';
});

const requiredCapsLock = computed((): boolean => currentKeyInfo.value?.level === 'capsLock');

const getOppositeZone = (): Zone | null => {
    const key = deadKeyInfo.value?.baseCharLevel?.key ?? currentKeyInfo.value?.key;
    if (!key) return null;
    return key.zone === Zone.Left ? Zone.Right : Zone.Left;
};

const toggleKeyboard = (): void => {
    isMinimized.value = !isMinimized.value;
};

const getKeyStyle = (key: KeyboardKey): Record<string, string> => {
    return { width: key.width ? `${key.width}px` : '40px' };
};

const isKeyHighlighted = (key: KeyboardKey): boolean => {
    const keyValue = key.value;

    if (keyValue === ' ') return nextChar.value === ' ';
    if (keyValue === 'enter') return nextChar.value === '\n';
    if (keyValue === 'shift') {
        if (!requiredShift.value) return false;
        return getOppositeZone() === key.zone;
    }
    if (keyValue === 'altgr') return requiredAltGr.value;
    if (keyValue === 'capslock') return requiredCapsLock.value;

    if (keyValue === 'ctrl' || keyValue === 'alt') {
        const isControlChar = nextChar.value !== '\n' && nextChar.value.match(/[\x00-\x1F\x7F]/);
        if (!isControlChar) return false;
        return getOppositeZone() === key.zone;
    }

    if (deadKeyInfo.value) {
        const deadKey = deadKeyInfo.value.deadKeyLevel?.key;
        const baseKey = deadKeyInfo.value.baseCharLevel?.key;
        return key === deadKey || key === baseKey;
    }

    if (currentKeyInfo.value) {
        return currentKeyInfo.value.key === key;
    }

    return false;
};
</script>
