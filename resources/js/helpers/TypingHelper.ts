export const isSuccess = (textLength: number, errors: number): boolean => {
    if (textLength <= 0) {
        return false;
    }

    return errors / textLength <= 0.25;
};
