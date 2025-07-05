import Lesson from '@/interfaces/Lesson';

export type LessonPartialInfo = Pick<Lesson, 'id' | 'number' | 'new_chars'>;
