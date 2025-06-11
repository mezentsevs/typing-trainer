<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6">Setup Lessons</h2>
            <form @submit.prevent="generateLessons">
                <div class="mb-4">
                    <InputLabel for="language" value="Language" />
                    <select id="language" v-model="form.language" class="w-full p-2 border rounded" required>
                        <option value="en">English</option>
                        <option value="ru">Russian</option>
                    </select>
                </div>
                <div class="mb-4">
                    <InputLabel for="lessonCount" value="Number" />
                    <Input
                        id="lessonCount"
                        v-model.number="form.lessonCount"
                        type="number"
                        min="1"
                        max="20"
                        class="w-full"
                        required
                    />
                </div>
                <PrimaryButton class="w-full">Generate</PrimaryButton>
            </form>
            <ErrorMessage :message="error" />
        </div>
    </div>
</template>

<script lang="ts" setup>
import ErrorMessage from '@/components/uikit/ErrorMessage.vue';
import Input from '@/components/uikit/Input.vue';
import InputLabel from '@/components/uikit/InputLabel.vue';
import LessonSetupFormInterface from '@/interfaces/LessonSetupFormInterface';
import PrimaryButton from '@/components/uikit/PrimaryButton.vue';
import axios from 'axios';
import { KeyboardLanguageEnum } from '@/enums/KeyboardEnums';
import { Ref, ref } from 'vue';
import { Router, useRouter } from 'vue-router';

const router: Router = useRouter();

const form: Ref<LessonSetupFormInterface> = ref({ language: KeyboardLanguageEnum.En, lessonCount: 10 });
const error: Ref<string> = ref('');

const generateLessons = async (): Promise<void> => {
    try {
        await axios.post('/lessons/generate', {
            language: form.value.language,
            lesson_count: form.value.lessonCount,
        });

        await router.push(`/lesson/${form.value.language}/1`);
    } catch (err: any) {
        error.value = 'Lessons generation failed';
    }
};
</script>
