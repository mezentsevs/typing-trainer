export const calculateElapsedTimeSeconds = (startTime: number): number =>
    Math.round((Date.now() - startTime) / 1000);

export const calculateSpeed = (typedLength: number, timeSeconds: number): number => {
    if (timeSeconds <= 0) {
        return 0;
    }

    return Math.round((typedLength / 5 / timeSeconds) * 60);
};

export const calculateErrors = (text: string, typed: string): number => {
    const length = Math.min(text.length, typed.length);
    let errorCount = 0;

    for (let i = 0; i < length; i++) {
        if (typed.charAt(i) !== text.charAt(i)) {
            errorCount++;
        }
    }

    return errorCount;
};

export const isSuccess = (textLength: number, errors: number): boolean => {
    if (textLength <= 0) {
        return false;
    }

    return errors / textLength <= 0.25;
};
