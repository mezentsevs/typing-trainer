<template>
    <BaseCard class="w-80">
        <template #base-card-logo>
            <slot name="logo" />
        </template>

        <slot />
    </BaseCard>
</template>

<script lang="ts" setup>
import BaseCard from '@/components/cards/BaseCard.vue';
</script>
