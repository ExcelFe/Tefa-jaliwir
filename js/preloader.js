/*
 * Cinematic homepage intro. Every direct homepage load (including refresh) plays it.
 * Dashboard pages keep their own skeleton loaders; public navigation skips this intro.
 */
(() => {
    'use strict';

    const overlay = document.getElementById('school-preloader');
    const root = document.documentElement;

    if (!overlay) {
        root.classList.remove('school-intro-active');
        return;
    }

    if (root.classList.contains('school-intro-skip')) {
        overlay.remove();
        root.classList.remove('school-intro-active');
        return;
    }

    const counter = overlay.querySelector('[data-preloader-counter]');
    const images = Array.from(overlay.querySelectorAll('img[data-preloader-asset]'));
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const MINIMUM_DURATION = prefersReducedMotion ? 900 : 1800;
    const PROGRESS_DURATION = MINIMUM_DURATION - 250;
    const MAXIMUM_DURATION = 9500;
    const EXIT_DURATION = prefersReducedMotion ? 160 : 1120;
    const startTime = performance.now();

    let settledImages = 0;
    let pageLoaded = document.readyState === 'complete';
    let finished = false;
    let animationFrame = 0;
    let maxWaitTimer = 0;
    let finishTimer = 0;
    let shownProgress = 0;

    const setCounter = (value) => {
        shownProgress = Math.max(0, Math.min(100, Math.round(value)));
        if (counter) counter.textContent = String(shownProgress).padStart(2, '0');
    };

    const removeIntro = () => {
        if (overlay.isConnected) overlay.remove();
        root.classList.remove('school-intro-active');
        root.classList.remove('school-intro-skip');
    };

    const finishIntro = () => {
        if (finished) return;
        finished = true;

        if (animationFrame) window.cancelAnimationFrame(animationFrame);
        if (finishTimer) window.clearTimeout(finishTimer);
        if (maxWaitTimer) window.clearTimeout(maxWaitTimer);

        setCounter(100);
        overlay.classList.add('is-exiting');
        overlay.setAttribute('aria-hidden', 'true');
        window.setTimeout(removeIntro, EXIT_DURATION + 80);
    };

    const maybeFinish = () => {
        if (finished || finishTimer || !pageLoaded || settledImages < images.length) return;
        const elapsed = performance.now() - startTime;
        const remaining = Math.max(0, MINIMUM_DURATION - elapsed);
        finishTimer = window.setTimeout(() => {
            finishTimer = 0;
            finishIntro();
        }, remaining);
    };

    const markImageSettled = (image) => {
        if (image.dataset.preloaderSettled === '1') return;
        image.dataset.preloaderSettled = '1';
        settledImages += 1;
        maybeFinish();
    };

    const animateCounter = () => {
        if (finished) return;
        const elapsed = performance.now() - startTime;
        // Count steadily from 00 to 97, then hold briefly until the page is ready.
        const timeProgress = Math.min(97, (elapsed / PROGRESS_DURATION) * 97);
        if (Math.round(timeProgress) > shownProgress) setCounter(timeProgress);
        animationFrame = window.requestAnimationFrame(animateCounter);
    };

    // Hard stop: stalled image requests can never keep the homepage inaccessible.
    maxWaitTimer = window.setTimeout(() => {
        pageLoaded = true;
        finishIntro();
    }, MAXIMUM_DURATION);

    window.addEventListener('load', () => {
        pageLoaded = true;
        maybeFinish();
    }, { once: true });

    images.forEach((image) => {
        if (image.complete) {
            markImageSettled(image);
            return;
        }
        image.addEventListener('load', () => markImageSettled(image), { once: true });
        image.addEventListener('error', () => markImageSettled(image), { once: true });
    });

    animationFrame = window.requestAnimationFrame(animateCounter);
    maybeFinish();
})();
