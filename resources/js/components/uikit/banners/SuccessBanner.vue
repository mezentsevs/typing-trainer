<template>
    <transition
        appear
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="opacity-0 scale-90"
        enter-to-class="opacity-100 scale-100">
        <BaseBanner class="text-green-500 flex items-center gap-1">
            <CheckIcon class="w-6 h-6" />
            <slot />
        </BaseBanner>
    </transition>
</template>

<script lang="ts" setup>
import BaseBanner from '@/components/uikit/banners/BaseBanner.vue';
import CheckIcon from '@/components/icons/CheckIcon.vue';
</script>
