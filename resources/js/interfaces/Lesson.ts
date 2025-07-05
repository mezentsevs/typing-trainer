import { Language } from '@/enums/KeyboardEnums';

export default interface Lesson {
    id: number;
    user_id: number;
    number: number;
    total: number;
    language: Language;
    new_chars: string;
    text: string;
    created_at: string;
    updated_at: string;
}
