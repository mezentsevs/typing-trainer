export default interface LessonProgressPayloadInterface {
    lesson_id: number;
    language: string;
    time_seconds: number;
    speed_wpm: number;
    errors: number;
}
