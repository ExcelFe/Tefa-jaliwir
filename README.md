# SMK TI Bali Global Badung - School Website (`tefa_jlwr`)

Plain HTML, CSS and JavaScript. No frameworks, no build step. Rules: [`rules.md`](./rules.md). Update this README with every code change.

## Status

| Page | Path | Status |
|------|------|--------|
| Home | `index.html` | Empty template |
| Login | `pages/login.html` | Done (no backend yet) |
| Profil Manajemen | `pages/before/profil-manajemen.html` | Empty file |
| Program Sekolah | `pages/before/program-sekolah.html` | Done |

## Quick start

Open a page in a browser. Google Fonts (Anton, Inter) need internet; without it the fallback `sans-serif` is used.

## Structure

```
tefa_jlwr/
├── index.html
├── README.md
├── rules.md
├── css/   main.css (tokens, base, layout, components, responsive) | animation.css (transitions)
├── js/    main.js (logic) | animation.js (empty, unused)
├── media/ logo.webp, email.png, lock.png
└── pages/ login.html | before/ program-sekolah.html, profil-manajemen.html | after/
```

## Design (reference: dropbox.com)

| Dropbox principle | Applied as |
|-------------------|------------|
| Big headline first, little copy | Large Anton `h1` per section |
| Near-black ink, one blue voltage | Text `#1E1919`; filled blue only for Login, Sign In, active tab |
| Soft surfaces, no outlines | Cards, rows, tabs, fields are tinted blue fills; no borders anywhere |
| Modest containers | PC/laptop: lists and tabs max `40rem`; 4 cards per row; login card `40rem`. Tablet: lists and tabs fill the width |
| Headline left, content right | `.list-ik/.list-kk/.list-ek` split at >= 1100px |
| Simple nav: brand, links, one CTA | Navbar; hamburger on tablet/phone |
| Multi-column footer | Brand + 3 link columns + copyright row |

Fonts unchanged: **Anton** (headings), **Inter** (body).

### Palette (`css/main.css`)

| Token | Value | Use |
|-------|-------|-----|
| `--Primary` | `#2563EB` | CTA buttons, active tab, focus ring |
| `--Secondary` | `#60A5FA` | Reserved (palette) |
| `--Text` | `#1E1919` | Text (near-black, not pure black) |
| `--Background` | `#F8FAFC` | Page background (unchanged) |
| `--Blue-900` | `#1E3A8A` | Current nav link text |
| `--Blue-700` | `#1D4ED8` | Button hover, card abbreviation |
| `--Blue-200` | `#BFDBFE` | Hover surfaces, card media, inputs |
| `--Blue-100` | `#DBEAFE` | Cards, rows, tabs, login card |
| `--Blue-50` | `#EFF6FF` | Footer |

Yellow (`--Accent`) removed. Other tokens: `--Text-Muted`, `--Radius-Md/Lg/Xl/Pill`, `--Space-1..6`, `--Container` (1200px), `--Gutter`, `--Content-Max` (40rem).

## Program Sekolah

Sections: navbar, Program Keahlian (4 cards), Intra-kulikuler (Kelas 10/11/12 x 12 subjects), Ko-kulikuler (3 rows), Ekstra-kulikuler (Olahraga 8, Kesenian 3, Teknologi 4, Akademik 2), footer. Layout refs: `example1.png`, `example2.png`.

- **Dropdowns:** closed on load/refresh; one open per section; list opens below the tabs and pushes content down.
- **Hamburger (<= 1024px):** `.nav-toggle` opens `#nav-panel`. Closes on link click, Escape, or resize to desktop.
- **Cards:** abbreviation placeholder (TJKT, PPLG, DKV, BD); swap the `<span>` for an `<img>` when logos exist.

## Login

Layout ref: `example3.png`. Body class `page-login` scopes the styles.

- **Grid** (`.container`): areas `back | greet | form`; one column at <= 640px.
- **Back button:** `history.back()`; home page if there is no history.
- **Form:** `required` fields, `method="post"`, no `action` (no backend). Icons: `email.png`, `lock.png`.
- No navbar on this page, so no hamburger.

## Responsive

| Width | Changes |
|-------|---------|
| >= 1100px | Headline left / content right for list sections |
| >= 1025px | Menu centred on the page; list sections get `1.5rem` extra top/bottom space |
| <= 1099px | Lists and tabs use the full container width |
| <= 1024px | Hamburger menu; cards 2 per row |
| <= 900px | Footer 1 column |
| <= 640px | Login card 1 column |
| <= 600px | Cards 1 per row; ekstra tabs 2 x 2 |
| <= 480px | Compact tabs and brand |
| <= 360px | Ekstra tabs 1 per row; `+` hidden on intra tabs |

Checked in Chromium at 1440, 1100, 820, 390, 320px: no horizontal scroll, no console errors.

## Editing content

- **Subject/item:** edit the `<li class="list">` in the matching panel.
- **Program card:** copy a `.cards` block, give it a new `id`, link it in the footer.
- **New tab:** add a `button.dropdown-trigger` + `.dropdown-panel` (`aria-controls` = panel `id`); set `--Trigger-Cols` in CSS.

## Decisions

| Decision | Why |
|----------|-----|
| Text `#1E1919` | Dropbox "Graphite"; near-black, not pure black |
| `--Background` kept | Brief: keep white background |
| Borders replaced by fills | Rule: no border colors |
| Surfaces one step darker (Blue-100) | Blue-50 is too close to the background |
| Hamburger at 1024px | Tablet and phone per rules |
| Desktop navbar is a 3-column grid (`1fr auto 1fr`) | Centres the menu on the page, not in the space left of the logo |
| Login styles under `.page-login` | `main .container` is the Program Sekolah layout |
| Tabs are `<button>` + panel, not `<details>` | List must sit below the whole tab row |

## Pending

- Program logos and social icons (svgrepo.com; slots marked `IMAGE SLOT` / `ICON SLOT`).
- Real contact numbers; privacy/terms URLs (`#`).
- Typos in content: "Perangakat" (PPLG), "Indsutri" (Ko-kulikuler).
- Login: no backend; "Forgot Password?" has no page; back arrow is a text glyph; brief said `logo.png`, file is `logo.webp`.

## Rules check

| Rule | Status |
|------|--------|
| README updated | Yes, terse |
| Structure unchanged | No files/folders added or moved |
| Only requested pages changed | `login.html`, `program-sekolah.html` + shared css/js |
| JS in `<head>` with `defer` | Yes |
| CSS in `main.css`, animation in `animation.css`, logic in `main.js` | Yes |
| No border colors | None (computed styles checked) |
| Containers capped | Yes |
| Hamburger on tablet/phone | Yes |
| No generated icons/images | None |

## Changelog

### 2026-10-12 - Layout tweaks (CSS only)
- PC/laptop (>= 1025px): menu centred on the page.
- Tablet (<= 1099px): Intra/Ko/Ekstra tabs and lists fill the full width.
- PC/laptop (>= 1025px): `1.5rem` extra space above and below Intra, Ko, Ekstra.

### 2026-10-11 - Dropbox restyle
- Palette: yellow removed; blue scale added; text `#1E1919`; background kept.
- Restyled `login.html` and `program-sekolah.html` after the Dropbox hierarchy: no borders, tinted surfaces, filled blue CTA, smaller containers, split headline/content layout.
- Navbar: wrapped menu + login in `#nav-panel`, added hamburger button (`program-sekolah.html`).
- `main.js`: nav toggle logic. `animation.css`: hamburger and hover transitions.
- Removed unused tokens `--Border`, `--Tint`, `--Tint-Strong`.
- Footer link hover: `Secondary` -> `Primary` (contrast).
- Comments and README shortened per new rules.

### 2026-10-09 - Login page
- Built `login.html` from `example3.png` (grid card, back button, form with icons).
- Fixed duplicate input ids, form `get` -> `post`, asset paths, `h2` -> `h1`.

### 2026-10-09 - Program Sekolah page
- Built `program-sekolah.html` from `example1.png` / `example2.png`: cards, exclusive dropdowns, footer.
