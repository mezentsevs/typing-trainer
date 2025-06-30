import { KeyboardLanguageEnum } from '@/enums/KeyboardEnums';

export default interface Lesson {
    id: number;
    user_id: number;
    number: number;
    total: number;
    language: KeyboardLanguageEnum;
    new_chars: string;
    text: string;
    created_at: string;
    updated_at: string;
}
