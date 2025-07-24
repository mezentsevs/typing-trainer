import TypingUnit from '@/interfaces/typing/TypingUnit';

const isSeparator = (char: string): boolean => char === ' ' || char === '\n';

export const getCurrentTypingUnit = (text: string, pos: number): TypingUnit | null => {
    if (pos >= text.length) { return null; }

    let start: number = pos;
    let end: number = pos;

    if (isSeparator(text[pos])) {
        while (start > 0 && isSeparator(text[start - 1])) { start--; }
        while (end < text.length - 1 && isSeparator(text[end + 1])) { end++; }

        return { start, end };
    } else {
        while (start > 0 && !isSeparator(text[start - 1])) { start--; }
        while (end < text.length - 1 && !isSeparator(text[end + 1])) { end++; }

        return { start, end };
    }
};
