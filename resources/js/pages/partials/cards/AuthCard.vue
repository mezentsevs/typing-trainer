<template>
    <BaseCard class="w-80">
        <template #base-logo>
            <slot name="logo" />
        </template>

        <slot />
    </BaseCard>
</template>

<script lang="ts" setup>
import BaseCard from '@/pages/partials/cards/BaseCard.vue';
</script>
