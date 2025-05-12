import CurrentTypingUnitInterface from '@/interfaces/CurrentTypingUnitInterface';

function isSeparator(char: string): boolean {
    return char === ' ' || char === '\n';
}

export function getCurrentTypingUnit(text: string, pos: number): CurrentTypingUnitInterface | null {
    if (pos >= text.length) { return null; }

    if (isSeparator(text[pos])) {
        let start = pos;
        while (start > 0 && isSeparator(text[start - 1])) { start--; }

        let end = pos;
        while (end < text.length - 1 && isSeparator(text[end + 1])) { end++; }

        return { start, end };
    } else {
        let start = pos;
        while (start > 0 && !isSeparator(text[start - 1])) { start--; }

        let end = pos;
        while (end < text.length - 1 && !isSeparator(text[end + 1])) { end++; }

        return { start, end };
    }
}
