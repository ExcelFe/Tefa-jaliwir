/* ==========================================================================
   GEOMETRYS.JS - background geometry shapes (circle / rectangle / triangle)
   Pages: Beranda, Profil Manajemen, Program Sekolah, 404 (Login has none).

   HOW IT WORKS
   - The HTML only holds empty zones:  <div class="deco" data-geo="KEY"></div>
   - This file fills every zone with random shapes: placement, size, color,
     rotation and AMOUNT are random on every page load (a refresh = new shapes).
   - Shapes never touch the "avoid" elements of their zone (cards, text, CTA,
     content columns) nor the big "404" letters. If there is no room left the
     zone simply gets fewer shapes, so the content is never covered.
   - Shapes stay behind all content: the layering is done in CSS (.deco, z-index -1).
   - Shape look (flat colors, shapes, screen scale): css/webpage.css (.deco-shape).

   SETTINGS (per zone)
     count   [min, max]  amount of shapes
     size    [min, max]  size in rem (before the CSS screen scale)
     colors  / types     what can be picked
     rotate  [min, max]  degrees (circles stay 0)
     gap     rem         minimum space between two shapes
     avoid   list of { sel, pad }   elements the shapes must stay away from
                                    (pad = extra rem around it, negative = may
                                    slip a bit behind it). sel ':parent' = the
                                    whole parent element of the zone.
     glyphs  selector    text whose letters the shapes must stay away from
   ========================================================================== */

(function () {
    'use strict';

    /* ======================================================================
       1. DEFAULTS (a zone only lists what it changes)
       ====================================================================== */
    const GEO_DEFAULTS = {
        count: [1, 3],
        size: [3.3, 4.8],
        colors: ['red', 'blue', 'green', 'orange'],
        types: ['circle', 'rect', 'triangle'],
        rotate: [-40, 40],
        gap: 1.5,
        avoid: [],
        glyphs: null
    };
    const TRIES_PER_SHAPE = 80;                         // placement attempts before giving up on a shape
    const RECT_RATIO = 0.62;                            // same as .deco-shape--rect (height / width)


    /* ======================================================================
       2. PAGE SECTIONS - one block per page (keys = data-geo in the HTML)
       ====================================================================== */

    /* ---------- BERANDA (index.html) ---------- */
    const GEO_HOME = {
        'home-transition': { count: [1, 3] },           // transition under the hero (empty, free placement)
        'home-content': {                               // behind the cards, Fasilitas and cool cards
            count: [2, 4],
            avoid: [
                { sel: '.home-card', pad: 1.5 },
                { sel: '.fasilitas', pad: 0.5 },
                { sel: '.cool-cards', pad: 0.5 }
            ]
        },
        'home-bottom': {                                // white part above the bottom cards
            count: [1, 3],
            avoid: [{ sel: '.home-card', pad: 1.5 }]
        }
    };

    /* ---------- PROFIL MANAJEMEN (pages/before/profil-manajemen.html) ---------- */
    const GEO_PROFIL = {
        'pm-transition-top': { count: [1, 3] },         // transition under the hero
        'pm-edge-top': {                                // white space above the first group
            count: [1, 2],
            avoid: [{ sel: '.pm-group', pad: 1 }]
        },
        'pm-gap': { count: [1, 2] },                    // white space above a group (used 3 times)
        'pm-edge-bottom': {                             // white space under the last group
            count: [1, 2],
            avoid: [{ sel: '.pm-group', pad: 1 }]
        },
        'pm-transition-bottom': { count: [1, 2] }       // transition above the footer
    };

    /* ---------- PROGRAM SEKOLAH (pages/before/program-sekolah.html) ---------- */
    const GEO_PROGRAM = {
        'ps-transition-top': { count: [1, 3] },         // transition under the hero
        'ps-sides': {                                   // side margins only (>= 1280px), never over the content column
            count: [3, 6],
            size: [3.3, 4.4],
            avoid: [{ sel: ':parent', pad: 1 }]
        },
        'ps-transition-bottom': { count: [1, 2] }       // transition above the footer
    };

    /* ---------- LOGIN (pages/login.html) ----------
       No shapes on this page. To add some later: add a zone key here, put
       <div class="deco" data-geo="KEY" aria-hidden="true"></div> in login.html
       and load js/geometrys.js there. */
    const GEO_LOGIN = {};

    /* ---------- 404 (404.html) ---------- */
    const GEO_404 = {
        '404-bg': {                                     // behind everything, full screen
            count: [10, 14],
            size: [3.5, 6],
            colors: ['white', 'white', 'blue', 'deep'],
            gap: 2,
            avoid: [{ sel: '.notfound-glass', pad: -2.5 }],     // may peek out from behind the container
            glyphs: '.notfound-bg-text'                         // never covers the big "404"
        },
        '404-card': {                                   // inside the container, smaller
            count: [12, 16],
            size: [1.5, 2.75],
            gap: 1,
            avoid: [
                { sel: '.notfound-title', pad: 1 },     // header + icon
                { sel: '.notfound-text', pad: 1 },
                { sel: '.btn-notfound', pad: 1 }
            ]
        }
    };

    const GEO_ALL = Object.assign({}, GEO_HOME, GEO_PROFIL, GEO_PROGRAM, GEO_LOGIN, GEO_404);


    /* ======================================================================
       3. ENGINE (no need to edit below to change amounts or sizes)
       ====================================================================== */
    const SEED = (Math.random() * 4294967296) >>> 0;    // new on every page load
    const rootPx = parseFloat(getComputedStyle(document.documentElement).fontSize) || 16;

    function mulberry32(a) {                            // small seeded random generator
        return function () {
            a |= 0; a = (a + 0x6D2B79F5) | 0;
            let t = Math.imul(a ^ (a >>> 15), 1 | a);
            t = (t + Math.imul(t ^ (t >>> 7), 61 | t)) ^ t;
            return ((t ^ (t >>> 14)) >>> 0) / 4294967296;
        };
    }

    /* Position of el inside `ancestor` from the layout (offset*), so animation
       transforms (cards flipping or sliding in) do not move it. */
    function layoutOffset(el, ancestor) {
        let x = 0, y = 0, node = el;
        while (node && node !== ancestor) {
            x += node.offsetLeft;
            y += node.offsetTop;
            node = node.offsetParent;
        }
        return node === ancestor ? { x, y } : null;
    }

    /* Rectangles (zone coordinates, px) the shapes must stay away from */
    function collectAvoidRects(zone, avoid) {
        const parent = zone.offsetParent;
        const rects = [];
        if (!parent) return rects;
        avoid.forEach((item) => {
            const pad = (item.pad || 0) * rootPx;
            if (item.sel === ':parent') {
                rects.push({ x: -zone.offsetLeft - pad, y: -zone.offsetTop - pad,
                             w: parent.offsetWidth + pad * 2, h: parent.offsetHeight + pad * 2 });
                return;
            }
            parent.querySelectorAll(item.sel).forEach((el) => {
                if (!el.offsetWidth || !el.offsetHeight) return;     // hidden
                const pos = layoutOffset(el, parent);
                if (!pos) return;
                rects.push({ x: pos.x - zone.offsetLeft - pad, y: pos.y - zone.offsetTop - pad,
                             w: el.offsetWidth + pad * 2, h: el.offsetHeight + pad * 2 });
            });
        });
        return rects;
    }

    function circleHitsRect(cx, cy, r, rect) {
        const nx = Math.max(rect.x, Math.min(cx, rect.x + rect.w));
        const ny = Math.max(rect.y, Math.min(cy, rect.y + rect.h));
        return (cx - nx) * (cx - nx) + (cy - ny) * (cy - ny) < r * r;
    }

    /* Mask of the big "404" letters: the text is drawn on a small canvas with
       the same font, size, position and tilt as the CSS, so shapes can test
       against the real letters. */
    function buildGlyphMask(zone, selector, padPx) {
        const el = document.querySelector(selector);
        if (!el) return null;
        const scale = 0.5;
        const canvas = document.createElement('canvas');
        canvas.width = Math.ceil(zone.offsetWidth * scale);
        canvas.height = Math.ceil(zone.offsetHeight * scale);
        const ctx = canvas.getContext('2d', { willReadFrequently: true });
        if (!ctx) return null;

        const cs = getComputedStyle(el);
        const fontSize = parseFloat(cs.fontSize);
        const matrix = new DOMMatrix(cs.transform === 'none' ? undefined : cs.transform);
        const angle = Math.atan2(matrix.b, matrix.a);
        ctx.font = cs.fontWeight + ' ' + fontSize + 'px ' + cs.fontFamily;
        const text = el.textContent.trim();
        const m = ctx.measureText(text);
        const ascent = m.fontBoundingBoxAscent !== undefined ? m.fontBoundingBoxAscent : fontSize * 0.97;
        const descent = m.fontBoundingBoxDescent !== undefined ? m.fontBoundingBoxDescent : fontSize * 0.25;

        // The element is centered on its left / top (translate -50% -50%), line-height 1.
        ctx.setTransform(scale, 0, 0, scale, 0, 0);
        ctx.translate(el.offsetLeft, el.offsetTop);
        ctx.rotate(angle);
        ctx.textAlign = 'center';
        ctx.textBaseline = 'alphabetic';
        ctx.fillStyle = '#000';
        ctx.strokeStyle = '#000';
        ctx.lineJoin = 'round';
        ctx.lineWidth = padPx * 2;                      // grows the letters = safe distance
        ctx.strokeText(text, 0, (ascent - descent) / 2);
        ctx.fillText(text, 0, (ascent - descent) / 2);

        return function hits(cx, cy, r) {
            const x0 = Math.max(0, Math.floor((cx - r) * scale));
            const y0 = Math.max(0, Math.floor((cy - r) * scale));
            const x1 = Math.min(canvas.width, Math.ceil((cx + r) * scale));
            const y1 = Math.min(canvas.height, Math.ceil((cy + r) * scale));
            if (x1 <= x0 || y1 <= y0) return false;
            const data = ctx.getImageData(x0, y0, x1 - x0, y1 - y0).data;
            for (let i = 3; i < data.length; i += 4) {
                if (data[i] > 0) return true;
            }
            return false;
        };
    }

    function fillZone(zone, index) {
        const cfg = Object.assign({}, GEO_DEFAULTS, GEO_ALL[zone.dataset.geo]);
        zone.querySelectorAll('.deco-shape').forEach((shape) => shape.remove());

        const W = zone.offsetWidth;
        const H = zone.offsetHeight;
        if (!W || !H) return;                           // hidden zone (e.g. --bleed under 1280px)

        const rnd = mulberry32(SEED + index * 7919);
        const between = (min, max) => min + (max - min) * rnd();
        const pick = (list) => list[Math.floor(rnd() * list.length)];

        const style = getComputedStyle(zone);
        const base = parseFloat(style.getPropertyValue('--deco-base')) || 1;
        const grow = parseFloat(style.getPropertyValue('--deco-grow')) || 1;
        const avoidRects = collectAvoidRects(zone, cfg.avoid);
        const hitsGlyph = cfg.glyphs ? buildGlyphMask(zone, cfg.glyphs, 0.75 * rootPx) : null;

        const target = Math.round(between(cfg.count[0], cfg.count[1]));
        const placed = [];
        const zoneIsIn = zone.classList.contains('is-in');

        for (let tries = 0; placed.length < target && tries < target * TRIES_PER_SHAPE; tries++) {
            const type = pick(cfg.types);
            const sizeRem = between(cfg.size[0], cfg.size[1]);
            const baseW = sizeRem * rootPx * base;      // --w in CSS (before the growth)
            const baseH = baseW * (type === 'rect' ? RECT_RATIO : 1);
            const visW = baseW * grow;                  // size on screen
            const visH = baseH * grow;
            const radius = type === 'circle' ? visW / 2 : Math.hypot(visW, visH) / 2;   // safe even when rotated
            if (visW > W || visH > H) continue;

            const cx = between(visW / 2, W - visW / 2);
            const cy = between(visH / 2, H - visH / 2);

            if (avoidRects.some((rect) => circleHitsRect(cx, cy, radius, rect))) continue;
            if (hitsGlyph && hitsGlyph(cx, cy, radius)) continue;
            if (placed.some((o) => Math.hypot(cx - o.cx, cy - o.cy) < radius + o.radius + cfg.gap * rootPx)) continue;

            placed.push({ cx, cy, radius });

            const shape = document.createElement('span');
            shape.className = 'deco-shape deco-shape--' + type + ' deco-shape--' + pick(cfg.colors);
            shape.style.setProperty('--x', ((cx - baseW / 2) / W * 100).toFixed(2) + '%');   // --x/--y = top-left before the growth
            shape.style.setProperty('--y', ((cy - baseH / 2) / H * 100).toFixed(2) + '%');
            shape.style.setProperty('--s', sizeRem.toFixed(2) + 'rem');
            shape.style.setProperty('--r', (type === 'circle' ? 0 : Math.round(between(cfg.rotate[0], cfg.rotate[1]))) + 'deg');
            if (zoneIsIn) shape.style.animation = 'none';   // rebuilt after a resize: do not rise again
            zone.appendChild(shape);
        }
    }

    function fillAll() {
        document.querySelectorAll('[data-geo]').forEach((zone, index) => {
            if (GEO_ALL[zone.dataset.geo]) fillZone(zone, index);
        });
    }


    /* ======================================================================
       4. START (after fonts + images, so text and cards have their final size)
       ====================================================================== */
    function start() {
        const fonts = document.fonts;
        const ready = fonts && fonts.load
            ? Promise.all([fonts.load('700 100px Montserrat', '404'), fonts.ready]).catch(() => {})
            : Promise.resolve();
        ready.then(fillAll);
    }
    if (document.readyState === 'complete') start();
    else window.addEventListener('load', start);

    /* Layout changes with the width (breakpoints, orientation): same seed, new fit.
       Height-only changes (phone address bar) are ignored. */
    let lastWidth = window.innerWidth;
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            if (window.innerWidth === lastWidth) return;
            lastWidth = window.innerWidth;
            fillAll();
        }, 250);
    });
}());
