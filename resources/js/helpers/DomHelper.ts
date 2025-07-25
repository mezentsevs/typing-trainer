export const scrollToCurrentChar = (
    textContainer: HTMLElement | null,
    currentIndex: number,
): void => {
    if (!textContainer) {
        return;
    }

    const charElements: NodeListOf<HTMLSpanElement> = textContainer.querySelectorAll('span');

    if (charElements[currentIndex]) {
        const charRect: DOMRect = charElements[currentIndex].getBoundingClientRect();
        const containerRect: DOMRect = textContainer.getBoundingClientRect();
        const offset: number = charRect.top - containerRect.top + textContainer.scrollTop;

        textContainer.scrollTo({ top: offset - containerRect.height / 2, behavior: 'smooth' });
    }
};
