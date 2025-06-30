<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
            <Heading :level="2" class="text-2xl mb-6">Setup Lessons</Heading>
            <form @submit.prevent="generateLessons">
                <InputLabel for="language" value="Language" />
                <Select
                    id="language"
                    v-model="form.language"
                    v-focus
                    :options="languages"
                    class="mb-4 w-full"
                    required
                />
                <InputLabel for="lessonCount" value="Number" />
                <Input
                    id="lessonCount"
                    v-model.number="form.lessonCount"
                    type="number"
                    min="1"
                    max="20"
                    class="mb-4 w-full"
                    required
                />
                <PrimaryButton class="w-full">Generate</PrimaryButton>
            </form>
            <ErrorMessage :message="error" />
        </div>
    </div>
</template>

<script lang="ts" setup>
import ErrorMessage from '@/components/uikit/ErrorMessage.vue';
import Heading from '@/components/uikit/Heading.vue';
import Input from '@/components/uikit/Input.vue';
import InputLabel from '@/components/uikit/InputLabel.vue';
import LessonSetupFormInterface from '@/interfaces/LessonSetupFormInterface';
import PrimaryButton from '@/components/uikit/PrimaryButton.vue';
import Select from '@/components/uikit/Select.vue';
import UIKitSelectOption from '@/interfaces/uikit/UIKitSelectOption';
import axios from 'axios';
import { KeyboardLanguageEnum } from '@/enums/KeyboardEnums';
import { Ref, ref } from 'vue';
import { Router, useRouter } from 'vue-router';

const router: Router = useRouter();

const form: Ref<LessonSetupFormInterface> = ref({ language: KeyboardLanguageEnum.En, lessonCount: 10 });
const error: Ref<string> = ref('');

const languages: UIKitSelectOption[] = [
    { label: 'English', value: KeyboardLanguageEnum.En },
    { label: 'Russian', value: KeyboardLanguageEnum.Ru },
];

const generateLessons = async (): Promise<void> => {
    try {
        await axios.post('/lessons/generate', {
            language: form.value.language,
            lesson_count: form.value.lessonCount,
        });

        await router.push(`/lesson/${form.value.language}/1`);
    } catch (err) {
        if (err instanceof Error) { error.value = 'Lessons generation failed'; }
    }
};
</script>
