<template>
    <div class="w-1/2 mx-auto my-4 border border-opacity-50 rounded-lg p-4">
        <div class="mb-4">
            <InputLabel for="genre">Genre <Remark value="(optional)" /></InputLabel>
            <Select
                id="genre"
                v-model="genre"
                v-focus
                :options="genres"
                class="w-full"
            />
        </div>
        <div class="mb-4">
            <InputLabel for="file">Text <Remark value="(optional, max 3 KB)" /></InputLabel>
            <input id="file" type="file" accept=".txt" @change="uploadFile" class="p-2 border rounded w-full" />
        </div>
        <PrimaryButton @click="$emit('start', genre)" class="w-full">Start</PrimaryButton>
        <ErrorMessage :message="error" />
    </div>
</template>

<script lang="ts" setup>
import ErrorMessage from '@/components/uikit/ErrorMessage.vue';
import InputLabel from '@/components/uikit/InputLabel.vue';
import PrimaryButton from '@/components/uikit/PrimaryButton.vue';
import Remark from '@/components/uikit/Remark.vue';
import Select from '@/components/uikit/Select.vue';
import UIKitSelectOptionInterface from '@/interfaces/uikit/UIKitSelectOptionInterface';
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

const genres: UIKitSelectOptionInterface[] = [
    { label: 'None', value: FinalTestGenreEnum.None },
    { label: 'Fiction', value: FinalTestGenreEnum.Fiction },
    { label: 'Non-fiction', value: FinalTestGenreEnum.NonFiction },
    { label: 'Poetry', value: FinalTestGenreEnum.Poetry },
];
</script>
