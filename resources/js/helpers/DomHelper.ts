export const scrollToCurrentChar = (textContainer: HTMLElement | null, currentIndex: number) => {
    if (!textContainer) return;

    const charElements = textContainer.querySelectorAll('span');
    if (charElements[currentIndex]) {
        const charRect = charElements[currentIndex].getBoundingClientRect();
        const containerRect = textContainer.getBoundingClientRect();
        const offset = charRect.top - containerRect.top + textContainer.scrollTop;
        textContainer.scrollTo({ top: offset - containerRect.height / 2, behavior: 'smooth' });
    }
};
