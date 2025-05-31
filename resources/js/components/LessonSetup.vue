<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6">Setup Lessons</h2>
            <form @submit.prevent="generateLessons">
                <div class="mb-4">
                    <label for="language" class="block text-gray-700">Language</label>
                    <select id="language" v-model="form.language" class="w-full p-2 border rounded" required>
                        <option value="en">English</option>
                        <option value="ru">Russian</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="lessonCount" class="block text-gray-700">Number</label>
                    <input
                        id="lessonCount"
                        v-model.number="form.lessonCount"
                        type="number"
                        min="1"
                        max="20"
                        class="w-full p-2 border rounded"
                        required
                    />
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">
                    Generate
                </button>
            </form>
            <ErrorMessage :message="error" />
        </div>
    </div>
</template>

<script lang="ts" setup>
import ErrorMessage from './ErrorMessage.vue';
import LessonSetupFormInterface from '@/interfaces/LessonSetupFormInterface';
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
