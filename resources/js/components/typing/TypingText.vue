<template>
    <span
        v-for="(char, index) in text"
        :key="index"
        :class="{
            'current-word': isCurrentWord[index],
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
defineProps<{
    text: string;
    typed: string;
    isCurrentWord: boolean[];
    isCompleted: boolean;
}>();
</script>
