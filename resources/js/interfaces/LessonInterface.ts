import { KeyboardLanguageEnum } from '@/enums/KeyboardEnums';

export default interface LessonInterface {
    id: number;
    user_id: number;
    number: number;
    total: number;
    language: KeyboardLanguageEnum;
    newChars: string;
    text: string;
    created_at: string;
    updated_at: string;
}
