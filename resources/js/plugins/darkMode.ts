export default {
    install(): void {
        const setDarkClass = (isDark: boolean): void => {
            const root: HTMLElement | null = document.getElementById('app');

            if (root) {
                isDark ? root.classList.add('dark') : root.classList.remove('dark');
            }
        };

        const handleThemeChange = (event: MediaQueryListEvent | MediaQueryList): void => {
            setDarkClass(event.matches);
        };

        const init = (): void => {
            const darkModeMediaQuery: MediaQueryList = window.matchMedia('(prefers-color-scheme: dark)');

            setDarkClass(darkModeMediaQuery.matches);

            darkModeMediaQuery.addEventListener('change', handleThemeChange);
        };

        init();
    },
}
