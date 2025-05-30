import { KeyboardLanguageEnum } from '@/enums/KeyboardEnums';

export default interface LessonSetupFormInterface {
    language: KeyboardLanguageEnum;
    lessonCount: number;
}
