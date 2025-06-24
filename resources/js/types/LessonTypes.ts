import LessonInterface from '@/interfaces/LessonInterface';

export type LessonInfoType = Pick<LessonInterface, 'id' | 'number' | 'newChars'>;
