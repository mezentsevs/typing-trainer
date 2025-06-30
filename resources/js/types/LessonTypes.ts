import Lesson from '@/interfaces/Lesson';

export type LessonPartialInfoType = Pick<Lesson, 'id' | 'number' | 'new_chars'>;
