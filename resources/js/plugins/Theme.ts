import { App, Ref, ref } from 'vue';

import Theme from '@/interfaces/app/Theme';

const isDark: Ref<boolean> = ref(false);

export default {
    install(app: App): void {
        const applyTheme = (dark: boolean): void => {
            const rootElement: HTMLElement | null = document.getElementById('app');

            if (rootElement) {
                rootElement.classList.toggle('dark', dark);
            }

            localStorage.setItem('theme', dark ? 'dark' : 'light');
            isDark.value = dark;
        };

        const handleDarkThemeChange = (event: MediaQueryListEvent): void => {
            applyTheme(event.matches);
        };

        const init = (): void => {
            const theme: string | null = localStorage.getItem('theme');
            const darkThemeMediaQueryList: MediaQueryList = window.matchMedia(
                '(prefers-color-scheme: dark)',
            );

            darkThemeMediaQueryList.addEventListener('change', handleDarkThemeChange);

            applyTheme(theme ? theme === 'dark' : darkThemeMediaQueryList.matches);
        };

        init();

        app.provide('theme', {
            isDark,
            toggleTheme: (): void => applyTheme(!isDark.value),
        } as Theme);
    },
};
