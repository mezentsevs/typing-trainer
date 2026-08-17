export interface BaseSaveResultRequestPayload {
    lesson_id?: number;
    language: string;
}

export interface SaveResultRequestPayload extends BaseSaveResultRequestPayload {
    time_seconds: number;
    speed_wpm: number;
    errors: number;
    success: boolean;
}
