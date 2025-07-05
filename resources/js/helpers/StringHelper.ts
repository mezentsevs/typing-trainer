import Unit from '@/interfaces/typing/Unit';

function isSeparator(char: string): boolean {
    return char === ' ' || char === '\n';
}

export function getCurrentTypingUnit(text: string, pos: number): Unit | null {
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
}
