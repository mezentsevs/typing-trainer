import LessonInterface from '@/interfaces/LessonInterface';

export type LessonPartialInfoType = Pick<LessonInterface, 'id' | 'number' | 'new_chars'>;
