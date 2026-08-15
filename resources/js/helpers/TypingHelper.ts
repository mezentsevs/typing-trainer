export const calculateElapsedTimeSeconds = (startTime: number): number =>
    Math.round((Date.now() - startTime) / 1000);

export const calculateSpeed = (typedLength: number, timeSeconds: number): number => {
    if (timeSeconds <= 0) {
        return 0;
    }

    return Math.round((typedLength / 5 / timeSeconds) * 60);
};

export const isSuccess = (textLength: number, errors: number): boolean => {
    if (textLength <= 0) {
        return false;
    }

    return errors / textLength <= 0.25;
};
