import { KeyboardLanguageEnum } from '@/enums/KeyboardEnums';

export default interface LessonSetupForm {
    language: KeyboardLanguageEnum;
    lessonCount: number;
}
