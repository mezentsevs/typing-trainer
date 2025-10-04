<template>
    <SetupCard>
        <Heading :level="1" class="text-2xl mb-6">Setup Final Test</Heading>
        <form @submit.prevent>
            <InputLabel for="genre">
                Genre
                <Remark value="(optional)" />
            </InputLabel>
            <Select id="genre" v-model="genre" v-focus :options="genres" class="mb-4 w-full" />
            <InputLabel for="file">
                Text
                <Remark value="(optional, max 3 KB)" />
            </InputLabel>
            <Input
                id="file"
                type="file"
                accept=".txt"
                class="mb-4 w-full"
                style="border-radius: 0.15rem"
                @change="uploadFile" />
            <PrimarySpinnerButton class="w-full" :loading="loading" @click="onStart">
                Start
            </PrimarySpinnerButton>
        </form>
        <ErrorMessage :message="error" />
    </SetupCard>
</template>

<script lang="ts" setup>
import { Genre } from '@/enums/FinalTestEnums';
import { Ref, ref } from 'vue';
import ErrorMessage from '@/components/uikit/messages/ErrorMessage.vue';
import Heading from '@/components/uikit/headings/Heading.vue';
import Input from '@/components/uikit/inputs/Input.vue';
import InputLabel from '@/components/uikit/inputs/partials/InputLabel.vue';
import PrimarySpinnerButton from '@/components/uikit/buttons/PrimarySpinnerButton.vue';
import Remark from '@/components/uikit/remarks/Remark.vue';
import Select from '@/components/uikit/inputs/Select.vue';
import SetupCard from '@/pages/partials/cards/SetupCard.vue';
import UIKitSelectOption from '@/interfaces/uikit/UIKitSelectOption';

defineProps<{
    error: string;
    uploadFile: (event: Event) => Promise<void>;
}>();

const emit = defineEmits<{
    (e: 'start', genre: string): void;
}>();

const genre: Ref<string> = ref('');
const loading: Ref<boolean> = ref(false);

const onStart = (): void => {
    loading.value = true;
    emit('start', genre.value);
};

const genres: UIKitSelectOption[] = [
    { label: 'None', value: Genre.None },
    { label: 'Fiction', value: Genre.Fiction },
    { label: 'Non-fiction', value: Genre.NonFiction },
    { label: 'Poetry', value: Genre.Poetry },
];
</script>
