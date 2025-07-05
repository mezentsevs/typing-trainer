<template>
    <SetupCard>
        <Heading :level="2" class="text-2xl mb-6">Setup Final Test</Heading>
        <form @submit.prevent>
            <InputLabel for="genre">Genre <Remark value="(optional)" /></InputLabel>
            <Select
                id="genre"
                v-model="genre"
                v-focus
                :options="genres"
                class="mb-4 w-full"
            />
            <InputLabel for="file">Text <Remark value="(optional, max 3 KB)" /></InputLabel>
            <Input
                id="file"
                type="file"
                accept=".txt"
                @change="uploadFile"
                class="mb-4 w-full"
                style="border-radius: 0.15rem"
            />
            <PrimaryButton @click="$emit('start', genre)" class="w-full">Start</PrimaryButton>
        </form>
        <ErrorMessage :message="error" />
    </SetupCard>
</template>

<script lang="ts" setup>
import ErrorMessage from '@/components/uikit/ErrorMessage.vue';
import Heading from '@/components/uikit/Heading.vue';
import Input from '@/components/uikit/Input.vue';
import InputLabel from '@/components/uikit/InputLabel.vue';
import PrimaryButton from '@/components/uikit/PrimaryButton.vue';
import Remark from '@/components/uikit/Remark.vue';
import Select from '@/components/uikit/Select.vue';
import SetupCard from '@/components/cards/SetupCard.vue';
import UIKitSelectOption from '@/interfaces/uikit/UIKitSelectOption';
import { Genre } from '@/enums/FinalTestEnums';
import { Ref, ref } from 'vue';

defineProps<{
    error: string,
    uploadFile: (event: Event) => Promise<void>,
}>();

defineEmits<{
    (e: 'start', genre: string): void;
}>();

const genre: Ref<string> = ref('');

const genres: UIKitSelectOption[] = [
    { label: 'None', value: Genre.None },
    { label: 'Fiction', value: Genre.Fiction },
    { label: 'Non-fiction', value: Genre.NonFiction },
    { label: 'Poetry', value: Genre.Poetry },
];
</script>
