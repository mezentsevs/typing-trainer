<template>
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-12 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <slot name="base-logo" />

        <div
            class="w-full p-6 sm:rounded-lg overflow-hidden bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm hover:shadow-md dark:hover:shadow-lg transition-shadow duration-200">
            <slot />
        </div>
    </div>
</template>
