export const calculateElapsedTimeSeconds = (startTime: number): number => {
    const millisecondsPerSecond: number = 1000;

    return Math.round((Date.now() - startTime) / millisecondsPerSecond);
};

export const calculateSpeed = (typedLength: number, timeSeconds: number): number => {
    if (timeSeconds <= 0) {
        return 0;
    }

    const secondsPerMinute: number = 60;
    const standardWordLength: number = 5;

    return Math.round((typedLength / standardWordLength / timeSeconds) * secondsPerMinute);
};

export const calculateErrors = (text: string, typed: string): number => {
    const length: number = Math.min(text.length, typed.length);
    let errorCount: number = 0;

    for (let i: number = 0; i < length; i++) {
        if (typed.charAt(i) !== text.charAt(i)) {
            errorCount++;
        }
    }

    return errorCount;
};

export const calculateProgress = (textLength: number, typedLength: number): number => {
    if (textLength <= 0) {
        return 0;
    }

    return Math.floor((typedLength / textLength) * 100);
};

export const isSuccess = (textLength: number, errors: number): boolean => {
    if (textLength <= 0) {
        return false;
    }

    const maxErrorRate: number = 0.25;

    return errors / textLength <= maxErrorRate;
};
