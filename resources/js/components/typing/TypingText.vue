<template>
    <span
        v-for="(char, index) in text"
        :key="index"
        :class="{
            'char-box': true,
            'current-word': index >= isCurrentWord.start && index <= isCurrentWord.end,
            space: char === ' ',
            'line-break': char === '\n',
            'current-char': index === typed.length && !isCompleted,
            'typed-char': typed[index] === char,
            'error-char': typed[index] && typed[index] !== char,
        }">
        {{ char }}
    </span>
</template>

<script lang="ts" setup>
import TypingUnit from '@/interfaces/typing/TypingUnit';

defineProps<{
    text: string;
    typed: string;
    isCurrentWord: TypingUnit;
    isCompleted: boolean;
}>();
</script>
