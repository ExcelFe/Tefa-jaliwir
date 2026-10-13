# SMK TI Bali Global Badung - School Website (`tefa_jlwr`)

Plain HTML, CSS and JavaScript. No frameworks, no build step. Rules: [`rules.md`](./rules.md). Update this README with every code change.

**Last updated: 2026-10-12** (merged with `Tefa-jaliwir-pio-branch`)

## Pages and links

| Page | Path | Notes |
|------|------|-------|
| Beranda | `index.html` | Hero, highlight card, kurikulum, fasilitas |
| Profil Manajemen | `pages/before/profil-manajemen.html` | 4 groups, "Selengkapnya" buttons |
| Program Sekolah | `pages/before/program-sekolah.html` | Warm theme, dropdown tabs |
| Login | `pages/login.html` | Warm theme, logo left / form right, no backend |
| Dashboards | `pages/after/tampilan-{admin,guru,guru-piket,siswa}.html` | Backend templates, pop-ups only |

- Navbar and footer link Beranda, Profil Manajemen, Program Sekolah, Login. Footer "Program Studi" links jump to the cards on Program Sekolah.
- Login back button: previous page, Beranda if no history.
- Dashboards link back to Beranda. Login to dashboard routing comes with the backend.
- Navbar/footer are copied into each page (no build step). Edit all 3 copies of a link together; paths differ per folder depth.

## Structure

```
tefa_jlwr/
├── index.html
├── README.md
├── rules.md
├── css/   main.css (all styles) | animation.css (transitions)
├── js/    main.js (shared) | program-sekolah.js | profil-manajemen.js | login.js | dashboard.js | animation.js (empty)
├── media/ logo.webp, landingsmkti.jpg, email.png, lock.png
└── pages/ login.html | before/ profil-manajemen.html, program-sekolah.html | after/ tampilan-*.html
```

## CSS (`css/main.css`)

Sections: 1 Fonts, 2 Tokens, 3 Base, 4 Layout, 5 Shared components (navbar, footer), 6 Home, 7 Profil Manajemen, 8 Program Sekolah, 9 Login, 10 Dashboards. Media queries sit under each section, mobile first.

- **Fonts:** `@import` at the top of `main.css`. Headings **Anton**, body **Plus Jakarta Sans**. No font `<link>` tags.
- **Theme:** `<body class="theme-warm">` switches page background and text to the warm palette (Program Sekolah, Login).
- **Icons:** Font Awesome `<link>` stays in the head (navbar login arrow, footer, Home, Profil).

| Token | Value | Use |
|-------|-------|-----|
| `--primary` / `--primary-dark` | `#1d4ed8` / `#1e40af` | Buttons, active tab, focus |
| `--secondary` | `#60a5fa` | Gradients |
| `--navy` / `--accent` | `#1e2a8a` / `#2ee6d6` | Headings, gradients, highlights |
| `--warm-50` / `100` / `200` | `#fff7ea` / `#fdebcb` / `#f5dcb0` | Warm page bg / rows, tabs, fields / hover, card media |
| `--warm-ink` | `#1e1919` | Warm-theme text |
| `--shadow-card` | warm brown shadow | Cards, no borders |

## JavaScript

All scripts are in `<head>` with `defer`.

| File | Used on | Does |
|------|---------|------|
| `main.js` | Every page | Hamburger menu, missing-image fallback |
| `program-sekolah.js` | Program Sekolah | Dropdown tabs, one open per group |
| `profil-manajemen.js` | Profil Manajemen | "Selengkapnya" toggle |
| `login.js` | Login | Back button |
| `dashboard.js` | `pages/after/*` | Pop-up open/close |
| `animation.js` | Home, Profil, Program, Login | Empty (JS animations go here) |

## Program Sekolah

Each block: headline first, content below. Tabs closed on load; list opens under the tab row. Cards use abbreviation placeholders (TJKT, PPLG, DKV, BD); swap the `<span>` for an `<img>` when logos exist.

## Login

Card = 2 columns (logo + school name | back button, headline, form). One column at <= 768px. Gradients mix navy, blue, cyan and warm cream. Inputs unchanged: email, password.

## Responsive

| Width | Changes |
|-------|---------|
| >= 1100px | Lists/tabs capped at `40rem` |
| >= 1025px | Full navbar (menu centred), 4 cards per row |
| <= 1024px | Hamburger menu |
| 600-1024px | 2 cards per row |
| <= 768px | Login stacks; hero centred |
| <= 600px | 1 card per row; ekstra tabs 2 x 2 |
| <= 480px | Compact tabs |
| <= 360px | Ekstra tabs 1 per row |

Checked in Chromium at 1440, 1100, 820, 390, 320px: no horizontal scroll, no console errors.

## Editing content

- **Program card:** copy an `article.program-card`, new `id`, add a footer link.
- **Tab:** add `button.dropdown-trigger` + `.dropdown-panel` (`aria-controls` = panel `id`), set `--trigger-cols` modifier.
- **Person card:** copy an `article.person`; photos go in `media/<group>/<group>-N.jpg`.
- **Hero photo:** `--hero-img` in `main.css`.

## Pending

- Photos: `media/manajemen|kaprog|guru|staff|fasilitas/` (missing files show a label).
- Program logos; real footer description; privacy/terms URLs (`#`).
- Typos in content: "Perangakat" (PPLG), "Indsutri" (Ko-kulikuler).
- Login: no backend; "Forgot Password?" has no page.
- Dashboards: unstyled backend templates; `/admin/...` and `/guru/...` routes need the backend.
- Existing borders kept on Home/Profil elements (hero tags, highlight card, fasilitas, person cards, "Selengkapnya"). New and restyled parts have none.

## Rules check

| Rule | Status |
|------|--------|
| README updated | Yes |
| JS in `<head>` with `defer` | Yes, all pages (inline scripts moved out) |
| CSS in `main.css`, transitions in `animation.css` | Yes |
| Logic in `main.js` + per-page files | Yes |
| No front-end frameworks | Yes |
| No border colors on Program Sekolah, Login, navbar, footer | Yes (computed styles checked) |
| Containers capped on PC/laptop/tablet | Yes |
| Hamburger on tablet/phone | Yes (<= 1024px) |
| No generated icons/images | Yes |

## Changelog

### 2026-10-12 - Merge + restyle
- Merged `tefa_jlwr_codebase_5` and `Tefa-jaliwir-pio-branch` into one codebase (this structure). B pages moved: `profil-manajemen.html` and `index.html` restyled paths; `after-log/` -> `pages/after/`; `assets/` -> `media/`.
- `main.css` = old `main.css` + `main2.css`, rewritten with one token set (kebab-case), readable rules, dead CSS removed (`.prodi-grid`, `.info-warp`, undefined `--bg`, `--primary-line`).
- Program Sekolah + Login restyled to the Beranda/Profil look (navbar, footer, cards, shadows); warm palette.
- Program Sekolah: headline first, tabs/list under it (was beside it). Heading levels and class names cleaned (`program-block`, `program-card`, `list-item`).
- Login: logo + school name left, form right; extra gradients; back button moved into the form panel. No new inputs.
- Fonts: body Inter -> Plus Jakarta Sans; headings Anton on all pages; Google Fonts `<link>` tags removed, `@import` used.
- JS split per page; shared logic in `main.js`. B's debug overflow logger removed. Dashboard inline scripts/styles moved to `dashboard.js` / `main.css`.
- Hamburger breakpoint on Beranda/Profil moved from 768px to 1024px (rules: tablet + phone).
- Navbar: "Program Keahlian" link renamed "Program Sekolah" and linked to the page.

### 2026-10-12 - Layout tweaks (CSS only)
- Menu centred on PC/laptop; tablet lists full width; extra spacing above/below list sections.

### 2026-10-11 - Dropbox restyle
- Blue palette, no borders, tinted surfaces, hamburger menu, smaller containers.

### 2026-10-09 - Login + Program Sekolah pages
- Built both pages from `example1-3.png`.
