document.addEventListener('DOMContentLoaded', (event) => {
    const progressBar = document.getElementById('progressBar');
    const container = document.querySelector('.container');
    const toc = document.getElementById('toc');
    const tocList = document.getElementById('toc-list');
    const tocToggle = document.querySelector('.toc-toggle');

    function updateProgressBar() {
        if (!container || !progressBar) return;

        const scrollTop = container.scrollTop;
        const scrollHeight = container.scrollHeight;
        const clientHeight = container.clientHeight;

        const maxScroll = scrollHeight - clientHeight;
        const scrollPercentage = maxScroll > 0 ? (scrollTop / maxScroll) * 100 : 0;

        progressBar.style.width = scrollPercentage + '%';
    }

    function generateTOC() {
        if (!toc || !tocList) return;

        const headings = document.querySelectorAll('.entry-content h1, .entry-content h2, .entry-content h3');
        tocList.innerHTML = '';

        headings.forEach((heading, index) => {
            const tocItem = document.createElement('li');
            const tocLink = document.createElement('a');
            const id = `heading-${index}`;
            heading.id = id;
            tocLink.href = `#${id}`;
            tocLink.textContent = heading.textContent;
            tocItem.appendChild(tocLink);
            tocList.appendChild(tocItem);
        });
    }

    function toggleTOC() {
        toc.classList.toggle('hidden');
    }

    // Initial TOC generation and progress bar update
    generateTOC();
    updateProgressBar();

    // Update progress bar on scroll
    container.addEventListener('scroll', updateProgressBar);

    // Toggle TOC button event listener
    if (tocToggle) {
        tocToggle.addEventListener('click', toggleTOC);
    }
});
