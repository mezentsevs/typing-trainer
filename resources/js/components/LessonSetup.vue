<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6">Setup Lessons</h2>
            <form @submit.prevent="generateLessons">
                <div class="mb-4">
                    <label class="block text-gray-700">Language</label>
                    <select v-model="form.language" class="w-full p-2 border rounded" required>
                        <option value="en">English</option>
                        <option value="ru">Russian</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Number of Lessons</label>
                    <input v-model.number="form.lesson_count" type="number" min="1" max="100" class="w-full p-2 border rounded" required />
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Generate Lessons</button>
            </form>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const form = ref({ language: 'en', lesson_count: 10 });

const generateLessons = async () => {
    try {
        await axios.post('/lessons/generate', form.value);
        router.push(`/lesson/${form.value.language}/1`);
    } catch (error) {
        alert('Failed to generate lessons');
    }
};
</script>
