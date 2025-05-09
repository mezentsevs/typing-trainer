export default interface LessonsProgressPayloadInterface {
    lessonId: number;
    language: string;
    timeSeconds: number;
    speedWpm: number;
    errors: number;
}
