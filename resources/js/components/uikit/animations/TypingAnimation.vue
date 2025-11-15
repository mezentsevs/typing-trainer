<template>
    <span class="inline-block">
        <span :class="textClass">{{ currentText }}</span>
        <span
            class="typing-cursor ml-1 inline-block h-[1em] border-solid border-r-[0.05em] align-middle"
            :class="cursorClass" />
    </span>
</template>

<script setup lang="ts">
import { onMounted, onUnmounted, ref, Ref } from 'vue';

interface TypingAnimationProps {
    text: string;
    textClass?: string;
    cursorClass?: string;
    animationInterval?: number;
    pauseTimeout?: number;
}

const props = withDefaults(defineProps<TypingAnimationProps>(), {
    textClass: '',
    cursorClass: 'border-r-current',
    animationInterval: 100,
    pauseTimeout: 2000,
});

const currentText: Ref<string> = ref('');

let animationInterval: ReturnType<typeof setInterval> | null = null;
let pauseTimeout: ReturnType<typeof setTimeout> | null = null;
let currentIndex: number = 0;
let isDeleting: boolean = false;

const startAnimation = (): void => {
    animationInterval = setInterval((): void => {
        if (!isDeleting) {
            if (currentIndex < props.text.length) {
                currentText.value += props.text[currentIndex];
                currentIndex++;
            } else {
                pauseTimeout = setTimeout((): void => {
                    isDeleting = true;
                    pauseTimeout = null;
                }, props.pauseTimeout);
            }
        } else {
            if (currentText.value.length > 0) {
                currentText.value = currentText.value.slice(0, -1);
            } else {
                isDeleting = false;
                currentIndex = 0;
            }
        }
    }, props.animationInterval);
};

const stopAnimation = (): void => {
    if (animationInterval) {
        clearInterval(animationInterval);
        animationInterval = null;
    }

    if (pauseTimeout) {
        clearTimeout(pauseTimeout);
        pauseTimeout = null;
    }
};

onMounted(startAnimation);
onUnmounted(stopAnimation);
</script>

<style scoped>
.typing-cursor {
    animation: blink-typing-cursor 0.75s step-end infinite;
}

@keyframes blink-typing-cursor {
    from,
    to {
        border-color: transparent;
    }
    50% {
        border-color: currentColor;
    }
}
</style>
