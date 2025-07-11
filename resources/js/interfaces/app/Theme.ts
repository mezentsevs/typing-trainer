import { Ref } from 'vue';

export default interface Theme {
    isDark: Ref<boolean>;
    toggleTheme: () => void;
}
