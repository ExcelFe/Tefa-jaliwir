/* ==========================================================================
   DASHBOARD SKELETON - in-layout loading state for after-login pages
   The preview mirrors the real content structure; the sidebar remains live.
   ========================================================================== */
(() => {
    'use strict';

    const content = document.querySelector('.dash-content');
    if (!content) return;

    const startedAt = (window.performance && performance.now) ? performance.now() : Date.now();
    const minimumVisible = 460;
    const preview = document.createElement('div');
    preview.className = 'dash-skeleton-preview';
    preview.setAttribute('aria-hidden', 'true');

    const makeBlock = (className, width, height, radius) => {
        const block = document.createElement('span');
        block.className = className;
        if (width) block.style.width = width;
        if (height) block.style.height = height;
        if (radius) block.style.borderRadius = radius;
        return block;
    };

    const copy = content.cloneNode(true);
    copy.querySelectorAll('[id]').forEach((node) => node.removeAttribute('id'));
    copy.querySelectorAll('script, style, noscript, template').forEach((node) => node.remove());
    copy.querySelectorAll('a').forEach((node) => {
        node.removeAttribute('href');
        node.removeAttribute('target');
        node.removeAttribute('role');
    });
    copy.querySelectorAll('[tabindex], [contenteditable], [autofocus]').forEach((node) => {
        node.removeAttribute('tabindex');
        node.removeAttribute('contenteditable');
        node.removeAttribute('autofocus');
    });

    // Replace images and SVG icons with neutral blocks of the same rendered size.
    const sourceMedia = Array.from(content.querySelectorAll('img, svg'));
    const copiedMedia = Array.from(copy.querySelectorAll('img, svg'));
    copiedMedia.forEach((node, index) => {
        const source = sourceMedia[index];
        const rect = source ? source.getBoundingClientRect() : { width: 24, height: 24 };
        const style = source ? window.getComputedStyle(source) : null;
        const media = makeBlock('dash-skeleton-shape dash-skeleton-media',
            `${Math.max(12, Math.round(rect.width || 24))}px`,
            `${Math.max(12, Math.round(rect.height || 24))}px`,
            style ? style.borderRadius : '0.35rem');
        node.replaceWith(media);
    });

    // Turn form controls into non-interactive placeholders while preserving their footprint.
    const sourceControls = Array.from(content.querySelectorAll('input, select, textarea, button'));
    const copiedControls = Array.from(copy.querySelectorAll('input, select, textarea, button'));
    copiedControls.forEach((node, index) => {
        const source = sourceControls[index];
        const rect = source ? source.getBoundingClientRect() : { width: 120, height: 40 };
        const style = source ? window.getComputedStyle(source) : null;
        const control = makeBlock('dash-skeleton-shape dash-skeleton-control',
            `${Math.max(30, Math.round(rect.width || 120))}px`,
            `${Math.max(18, Math.round(rect.height || 40))}px`,
            style ? style.borderRadius : '0.65rem');
        control.append(makeBlock('dash-skeleton-line', '42%', '0.56em', '999px'));
        node.replaceWith(control);
    });

    // Replace all meaningful text nodes with variable-length shimmer lines.
    const walker = document.createTreeWalker(copy, NodeFilter.SHOW_TEXT);
    const textNodes = [];
    while (walker.nextNode()) textNodes.push(walker.currentNode);
    textNodes.forEach((node) => {
        const text = (node.nodeValue || '').replace(/\s+/g, ' ').trim();
        if (!text) { node.remove(); return; }
        const length = text.replace(/\s/g, '').length;
        const width = Math.max(1.8, Math.min(22, length * 0.46));
        const line = makeBlock('dash-skeleton-line', `${width}ch`, '0.72em', '999px');
        node.replaceWith(line);
    });

    copy.classList.remove('dash-content');
    copy.classList.add('dash-skeleton-preview__content');
    preview.append(copy);

    // Two dashboard pages are intentionally empty placeholders today (edit app / school map).
    // Give them a lightweight content scaffold so the skeleton still indicates future content areas.
    if (!content.children.length || !content.textContent.trim()) {
        const empty = document.createElement('div');
        empty.className = 'dash-skeleton-empty';
        const header = document.createElement('div');
        header.className = 'dash-skeleton-empty__header';
        header.append(makeBlock('dash-skeleton-line', 'min(16rem, 42%)', '1.15rem'));
        header.append(makeBlock('dash-skeleton-shape dash-skeleton-empty__tool', '10rem', '2.65rem', '999px'));
        const cards = document.createElement('div');
        cards.className = 'dash-skeleton-empty__cards';
        for (let i = 0; i < 3; i += 1) {
            const card = document.createElement('div');
            card.className = 'dash-skeleton-empty__card';
            card.append(makeBlock('dash-skeleton-shape', '2.4rem', '2.4rem', '0.7rem'));
            card.append(makeBlock('dash-skeleton-line', '72%', '0.78rem'));
            card.append(makeBlock('dash-skeleton-line', '48%', '0.58rem'));
            cards.append(card);
        }
        const panel = document.createElement('div');
        panel.className = 'dash-skeleton-empty__panel';
        for (let i = 0; i < 5; i += 1) {
            const row = document.createElement('div');
            row.className = 'dash-skeleton-empty__row';
            row.append(makeBlock('dash-skeleton-line', `${38 + (i % 3) * 13}%`, '0.7rem'));
            row.append(makeBlock('dash-skeleton-line', '18%', '0.62rem'));
            panel.append(row);
        }
        empty.append(header, cards, panel);
        preview.append(empty);
    }

    content.classList.add('is-skeleton-loading');
    content.append(preview);

    let isRemoved = false;
    const removeSkeleton = () => {
        if (isRemoved) return;
        isRemoved = true;
        content.classList.remove('is-skeleton-loading');
        preview.classList.add('is-skeleton-hiding');
        window.setTimeout(() => preview.remove(), 220);
    };

    const finishAfterMinimum = () => {
        const now = (window.performance && performance.now) ? performance.now() : Date.now();
        const wait = Math.max(0, minimumVisible - (now - startedAt));
        window.setTimeout(removeSkeleton, wait);
    };

    if (document.readyState === 'complete') {
        finishAfterMinimum();
    } else {
        window.addEventListener('load', finishAfterMinimum, { once: true });
    }

    // Re-show a brief skeleton when the browser restores this dashboard from its back/forward cache.
    window.addEventListener('pageshow', (event) => {
        if (!event.persisted || !isRemoved) return;
        isRemoved = false;
        const freshPreview = preview.cloneNode(true);
        freshPreview.classList.remove('is-skeleton-hiding');
        content.append(freshPreview);
        content.classList.add('is-skeleton-loading');
        window.setTimeout(() => {
            if (!isRemoved) {
                isRemoved = true;
                content.classList.remove('is-skeleton-loading');
                freshPreview.classList.add('is-skeleton-hiding');
                window.setTimeout(() => freshPreview.remove(), 220);
            }
        }, 280);
    });
})();
