<template>
    <div class="w-1/2 mx-auto my-4 border border-opacity-50 rounded-lg p-4">
        <Heading :level="3" class="text-xl mb-4">Setup</Heading>
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
    </div>
</template>

<script lang="ts" setup>
import ErrorMessage from '@/components/uikit/ErrorMessage.vue';
import Heading from '@/components/uikit/Heading.vue';
import Input from '@/components/uikit/Input.vue';
import InputLabel from '@/components/uikit/InputLabel.vue';
import PrimaryButton from '@/components/uikit/PrimaryButton.vue';
import Remark from '@/components/uikit/Remark.vue';
import Select from '@/components/uikit/Select.vue';
import UIKitSelectOption from '@/interfaces/uikit/UIKitSelectOption';
import { FinalTestGenreEnum } from '@/enums/FinalTestEnums';
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
    { label: 'None', value: FinalTestGenreEnum.None },
    { label: 'Fiction', value: FinalTestGenreEnum.Fiction },
    { label: 'Non-fiction', value: FinalTestGenreEnum.NonFiction },
    { label: 'Poetry', value: FinalTestGenreEnum.Poetry },
];
</script>
