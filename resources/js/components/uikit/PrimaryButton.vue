<template>
    <BaseButton :type class="bg-blue-500 dark:bg-gray-200">
        <slot />
    </BaseButton>
</template>

<script lang="ts" setup>
import BaseButton from '@/components/uikit/BaseButton.vue';
import { UIKitButtonType } from '@/types/UIKitTypes';
import { UIKitButtonTypeEnum } from '@/enums/UIKitEnums';

withDefaults(defineProps<{
    type?: UIKitButtonType,
}>(), {
    type: UIKitButtonTypeEnum.Submit,
});
</script>
