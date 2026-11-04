## 2026-11-04 — Phone fixes: loading screen, Beranda cards (codebase_28)

- Loading screen (`preloader.css`, <= 760px): GLOBALITI is now `16vw` with no px minimum (was `22vw` / `21vw`, min 72px) and `text-indent` `-.095em` (was `-.4em`, pushed it off the left edge). Other text is smaller too: WELCOME TO 7px, school line 9px (8px <= 390px), counter 28px. Fits 320 to 767px, centred. Applies to all 4 public pages (same loader).
- Beranda cards (`webpage.css`, <= 767px, block after `.bottom-cards__last`):
  - Naga on phones: `--naga-w` min `1300px` (was `1100px`), so every zone is about 18% taller.
  - Red card `0.06` of the naga height (was `0.115`), blue card 15.5rem under it: blue ends about 190px above Fasilitas (was 16px inside).
  - Green card `0.045` (was `0.078`), orange card 19rem under it: gap about 95px (was 39px), orange stays inside its zone (was 81px outside).
  - Bottom first zone +3rem, last zone -3rem, 3D cards axis -3rem: total height unchanged, 3D cards stay on the naga tail (same x, y off by under 1%).
- Not changed: tablet and desktop (>= 768px), HTML, JS.
- Checked in Chromium at 320, 360, 384, 390, 430, 600, 767px: no horizontal scroll, no overflow into the next zone, GLOBALITI inside the screen. 768, 1024, 1440px measured the same as before.

## 2026-11-03 — Login form states: fade instead of slide (codebase_27)

- Slide replaced by a fade in-out: a color layer (red / green) with the message fades 0 → 80% → 0 over each field, same 1.5s. First half in, second half out.
- Ring color now fades from none (or the blue focus ring) to red / green over the same 1.5s, instead of switching at once. Error: ring resets with the cleared fields. Success: green stays until the dashboard loads.
- Typed text and icons fade out and back with the layer (`opacity`, replaces the `color` / placeholder / autofill rules).
- Editable in `animation.css` (`.login-field`): `--state-duration` (JS reads it, so clearing / redirect still waits for the end), `--state-easing`, `--state-peak-opacity`. Colors: `--state-error`, `--state-success` in `webpage.css`.
- Class `.is-sliding` renamed `.is-animating`. Removed `login-slide`, `login-hold`, `--slide-dir`. Reduced motion: fade kept (no movement left).
- Checked in Chromium: layer peaks at 0.8 at 0.75s, ring ends on the state color, fields cleared / dashboard opened after 1.5s, and a changed `--state-duration` (800ms) is respected.

## 2026-11-03 — Login: custom form states (codebase_25, slide version, replaced above)

- Native "Please fill out this field" bubble replaced by two custom states (`form.noValidate` in `login.js`; `required` / `type=email` still used as checks).
- Error (wrong, empty or malformed data): both field rings turn red at once, a red 75% layer slides left to right (translate X) over each field for 1.5s, fast in (0-0.5s), slow (0.5-1s) while "Email/Password Salah!" shows on both fields, fast out. Fields are cleared only after the slide; focus returns to Email.
- Success: same in green, mirrored (right to left), "Berhasil Masuk ke Akun!" on both fields. The dashboard loads only after the slide. Flip direction: `--slide-dir` in `animation.css` (`1` = left to right, `-1` = right to left).
- Typed text is hidden under the slide, then comes back. Submit is locked during the slide. Reduced motion: no slide, the layer holds 1.5s and fades.
- Files: `login.html` (+1 hidden `role="status"` line for screen readers), `webpage.css` (section 9: state tokens, ring, layer), `animation.css` (`login-slide`, `login-hold`), `login.js` (`initLoginForm`).
- No backend yet: `authenticate()` in `login.js` checks 4 demo accounts (`admin@`, `guru@`, `piket@`, `siswa@globaliti.test`, password `globaliti123`) and picks the dashboard by role. Replace it and delete the accounts when the backend is connected.
- Checked in Chromium (1440 and 390px): ring red/green at once, slide 1.5s with slow middle, clear/redirect only after the slide, no double submit, no new console errors.

## 2026-11-01 — Before-login pages: hero zoom, Sign In hover, shapes

- Beranda + Program Sekolah: hero zoom scroll distance now the same as Profil Manajemen (`--hero-extra: 90svh`, `webpage.css`).
- Login: Sign In hover is a 180ms ease-in-out fade (reversed gradient layer `.btn-signin::before`, because a gradient cannot transition).
- Background shapes (`.deco-shape`): 40% bigger on Beranda, Profil Manajemen, Program Sekolah (`--deco-grow: 1.4`), grown around their old centre so placement stays. Login has no shapes.
- Shapes inside the transitions (top + bottom) rise in once, bottom to top (translate Y, `deco-rise` in `animation.css`, `initDecoRise` in `animation.js`, `data-deco-rise` on the 6 transition zones). Shapes between the Profil groups and in the content zones stay static.

## 2026-10-31 — Public preloader switched to monochrome counter transition

- Replaced the unrelated orb treatment with the sequence shown in the supplied screenshots: a black `Almost There` screen with `100`, a white `Loading` screen with a bottom-centered counter, and an ending where `Loading` rises and tilts while a black panel wipes from right to left.
- Kept the school's logo and name as a small, low-contrast identifier at the lower left so the loader remains connected to the school website without crowding the reference layout.
- The progress counter advances while the page is loading and reaches `100` only after the browser load event; the preloader remains limited to the four public pages.
- Kept all 15 authenticated dashboard pages on skeleton loading. No dashboard HTML, CSS, JavaScript, or skeleton assets were changed.

## 2026-10-31 — Public preloader reference correction

- Simplified the public preloader to match the Webflow reference composition more closely: large two-line headline at upper left, glowing white orb travelling along a thin semicircular arc, `Loading...` beside the arc, and a compact school logo/name at lower left.
- Removed the extra percentage counter, status paragraph, turquoise accent treatment, decorative grid/rings, and extra footer copy that made the previous version diverge from the reference.
- Kept the preloader only on the four public pages. All 15 after-login dashboard pages continue to use their existing skeleton loading UI; dashboard and skeleton files were left unchanged.

# SMK TI Bali Global Badung - School Website (`tefa_jlwr`)

Plain HTML, CSS and JavaScript. No frameworks, no build step. Rules: [`rules.md`](./rules.md). Update this README with every code change.

**Last updated: 2026-11-04**

## Pages and links

| Page | Path | Notes |
|------|------|-------|
| Beranda | `index.html` | Pinned zoom hero (2 states), gradient transition, naga main content (6 cards, fasilitas carousel, 3D cards), background shapes |
| Profil Manajemen | `pages/before/profil-manajemen.html` | Pinned zoom hero (2 states), 4 colored groups (photos only), photo + list pop-ups, background shapes |
| Program Sekolah | `pages/before/program-sekolah.html` | Warm theme, zoom hero, flip cards, pop-ups, floating navbar, background shapes |
| Login | `pages/login.html` | Warm theme, logo left / form right, red/green fade states, demo accounts (no backend) |
| Admin: Status Guru | `pages/after/admin/admin-status.html` | Teacher status list, placeholders |
| Admin: Pilih Guru Piket | `pages/after/admin/admin-piket.html` | Today's guru piket, log, "Pilih Guru Piket" pop-up |
| Admin: Rekap Siswa | `pages/after/admin/admin-rekap-siswa.html` | Rekap list per class, download buttons |
| Admin: Rekap Guru | `pages/after/admin/admin-rekap-guru.html` | Rekap list per teacher, download buttons |
| Admin: Edit App | `pages/after/admin/admin-edit.html` | Empty (sidebar only) |
| Guru Piket: Status Guru | `pages/after/guru-piket/piket-status.html` | Teacher status list, placeholders |
| Guru Piket: Absen Guru | `pages/after/guru-piket/piket-absen.html` | Log + "Mulai Absensi" pop-up form (36 teachers) |
| Guru Piket: Jadwal | `pages/after/guru-piket/piket-jadwal.html` | Schedule list per class, download buttons |
| Guru: Jadwal | `pages/after/guru/guru-jadwal.html` | Teacher home, placeholder schedule |
| Guru: Absen Siswa | `pages/after/guru/guru-absen.html` | Log + "Mulai Absensi" pop-up form |
| Guru: Jurnal Kelas | `pages/after/guru/guru-jurnal.html` | Log + "Tambah Jurnal" pop-up form |
| Guru: Rekap Absensi | `pages/after/guru/guru-rekap.html` | Rekap list, download buttons |
| Siswa: Jadwal | `pages/after/siswa/siswa-jadwal.html` | Today + full schedule placeholders |
| Siswa: Status Guru | `pages/after/siswa/siswa-status.html` | Teacher status list, placeholders |
| Siswa: Denah Sekolah | `pages/after/siswa/siswa-denah.html` | Empty (sidebar only) |

- Navbar and footer link Beranda, Profil Manajemen, Program Sekolah, Login. Footer "Program Studi" links jump to the cards on Program Sekolah.
- Login back button: previous page, Beranda if no history.
- Dashboards link back to Beranda. Login opens a dashboard by role for the demo accounts only; real routing comes with the backend.
- Navbar/footer are copied into each page (no build step). Edit all 3 copies of a link together; paths differ per folder depth.

## Structure

```
tefa_jlwr/
├── index.html
├── README.md
├── rules.md
├── css/   webpage.css (pages before login) | dashboard.css (pages after login) | animation.css (transitions)
├── js/    main.js (shared) | animation.js (scroll-sequence) | cool-cards.js (index) | program-sekolah.js | profil-manajemen.js | login.js | dashboard.js
├── media/ logo.webp, landingsmkti.jpg, naga-basuki.png, vector/dropdown.png, email.png, lock.png
└── pages/ login.html | before/ profil-manajemen.html, program-sekolah.html | after/ admin/ guru/ guru-piket/ siswa/
```

## CSS (`css/webpage.css`, `css/dashboard.css`)

`webpage.css` sections: 1 Fonts, 2 Tokens, 3 Base, 4 Layout, 5 Shared components (navbar, footer), 6 Home, 7 Profil Manajemen, 8 Program Sekolah, 9 Login. `dashboard.css`: after-login tokens (`--sb-*`, `--status-*`), 10 Pop-up modals, 11 Dashboards (`.dash-*`). After-login pages load `webpage.css` first (tokens, base), then `dashboard.css`. Media queries sit under each section, mobile first.

- **Fonts:** `@import` at the top of `webpage.css`. Headings **Montserrat Bold (700)**, body **Plus Jakarta Sans**. No font `<link>` tags.
- **Theme:** `<body class="theme-warm">` switches page background and text to the warm palette (Program Sekolah, Login).
- **Background shapes (`.deco`, section 5):** flat circles, rectangles, triangles (card colors, no shading) behind the content of Beranda, Profil Manajemen, Program Sekolah. Static, except the ones in the transitions (rise in once). See Background shapes.
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
| `program-sekolah.js` | Program Sekolah | Flip cards (Program Keahlian), pop-up lists (Intra-/Ekstra-kulikuler) |
| `profil-manajemen.js` | Profil Manajemen | Pop-ups: all photos of Guru/Staff, one person (photo + description) |
| `login.js` | Login | Back button, password toggle, form states (error / success fade), demo `authenticate()` |
| `dashboard.js` | `pages/after/*` | Pop-up open/close |
| `main.js` (dashboard part) | `guru/*`, `siswa/*`, `guru-piket/*`, `admin/*` | Theme switch, sidebar, settings menu (Learn More click on touch/phone), pop-ups |
| `guru-absen-siswa.js` | Absen Siswa, Absen Guru (piket) | Hadir / Tidak Hadir checkboxes |
| `admin-piket.js` | Admin Pilih Guru Piket | Today's date, placeholder code, copy button |
| `animation.js` | Home, Profil, Program Sekolah (all pages load it) | Scroll-sequence (`--seq`) for `[data-seq]`: flip (Home cards), slide up + fade (3D cards), slide from the side (`data-seq-from`, Profil groups, Program Ko-kulikuler); hero zoom (`initHeroZoom`: `--hero-p`, `--hero-r`, Profil; `initHeroPin`: `--hero-progress`, Beranda + Program); compact/full reveal grids + Ko-kulikuler reveal (Program). Entry animations play once per page load (see Entry animations) |
| `cool-cards.js` | Home | 3D cards: only one at the center |
| `main.js` (home part) | Home | Halaman dropdown, floating navbar, fasilitas carousel + pop-up |

## Program Sekolah

Hero (`.hero-pin`, reuses `.home-hero`, no navbar over it; same hero pin as Beranda, CSS in section 6): default = headline only; scrolling pins + zooms the photo a touch, reveals sub-text + CTA (`--hero-progress`, `initHeroPin`, `[data-hero-pin]`), then releases into normal scroll. Reduced motion: no pin, reveal shown at once. Navbar = same floating navbar as Beranda and Profil (`.navbar--float`, shows after 50% of the top transition, `[data-navbar-sentinel]`, `initHomeNavbar` in `main.js`).

Each block: headline first, content below (`[data-seq]`; Ko-kulikuler slides in from the right, `data-seq-from="right"`).

**Program Keahlian:** 4 flip cards (PPLG, DKV, BD, TJKT; color per card, `--keahlian-*`). `[data-reveal]` grid: compact on enter, full (label shown) once scrolled further (`initRevealGrids`). Click flips the card (3D, `rotateY`); click the flipped card opens the enlarged pop-up.

**Intra-/Ekstra-kulikuler:** same compact/full cards (3 classes / 4 categories). Click opens the shared pop-up (`#card-modal`) with the subject list, cloned from a `<template>` in the page.

**Ko-kulikuler:** static panel (`.koku-panel`), full viewport width (no radius), enters from the right. Rows fade in only once the panel is fully in view (`initKokuReveal`).

**Shared pop-up:** `#card-modal`, closes on the X, Escape, or an outside click (also un-flips Program Keahlian cards). Mobile: box capped at 80vh.

Transitions: top `clamp(18rem, 60svh, 31rem)`, bottom `clamp(12rem, 28svh, 22rem)` (was 14-24rem / 9-16rem).

## Beranda

Hero (`.hero-pin` > `.hero-sticky` > `.home-hero`): default state = tags + headline only; sub-text and Login/Halaman CTA (`.hero-reveal`) are hidden. Scrolling pins the hero, zooms the photo a touch and reveals them (`--hero-progress`, `initHeroPin`, `[data-hero-pin]`), then the page scrolls on. Reduced motion: no pin, everything shown. No JS: everything shown (`<noscript>`). `.hero-sticky` clips only sideways (`overflow-x: clip`) so the Halaman menu is never cut off on short screens.

## Profil Manajemen groups

White space between two groups: `--pm-space-y` (`clamp(7rem, 16vw, 13rem)`, was 6rem + 40px at most). Group size: `--pm-scale` (0.7, 0.82 on phones, brown 0.7) scales the photo grid width (`max-width: var(--maxw) * scale`); paddings, strip, "Cek Profil" text are smaller too. Two-row groups are about a third shorter.

## Entry animations (play once)

`[data-seq]` items (cards, Profil groups, Ko-kulikuler), the Program compact/full grids (`.is-full`) and the Ko-kulikuler rows (`.is-shown`) play once. After they have fully entered they stay in place when the user scrolls up or down again. A refresh resets them (nothing is stored). Hero zooms are not entry animations: they stay scroll-linked both ways.

## Background shapes

Markup: `<div class="deco" aria-hidden="true">` with `span.deco-shape.deco-shape--circle|rect|triangle` + `--red|blue|green|orange`, position/size/rotation as inline `--x --y --s --r`. The zone around it has `position: relative; isolation: isolate` and the `.deco` has `z-index: -1`, so shapes sit above the zone background and below everything else (Beranda `.deco--fifth` uses `z-index: 0`, because `.bottom-cards` must not isolate: the cards stay above the naga). Placement was generated randomly once and is fixed in the HTML (Beranda 7, Profil 10, Program 8). In the transitions shapes only exist in the light half: top transition = lower half (`.deco--lower-half`), bottom transition = upper half (`.deco--upper-half`; Beranda: white part of the bottom gradient, `.deco--fifth`). Profil: shapes sit in the white space above each group (`.deco--gap`) and above the first / below the last group (`.deco--edge-top|bottom`). Program: full-width layer (`.deco--bleed`, only >= 1280px, so no shape sits under text). Shapes are 30% smaller on phones. To change a shape, edit its inline values; delete the span to remove it.

## Login

Card = 2 columns (logo + school name | back button, headline, form). One column at <= 768px. Gradients mix navy, blue, cyan and warm cream. Inputs unchanged: email, password. Submit shows a 1.5s red (error) or green (success) fade in-out with a message on both fields; colors `--state-error` / `--state-success` on `.page-login`, timing `--state-duration` / `--state-easing` / `--state-peak-opacity` in `animation.css`.

## Responsive

| Width | Changes |
|-------|---------|
| >= 1025px | Full navbar (menu centred) |
| <= 1024px | Hamburger menu |
| >= 600px | Program Keahlian / Ekstra-Kulikuler: 2 x 2 |
| >= 480px | Intra-Kulikuler: 3 columns |
| <= 1279px | Program Sekolah: full-width shape layer hidden |
| <= 768px | Login stacks; hero centred; shapes 30% smaller; Profil groups narrower |
| <= 767px | Beranda: naga min 1300px, top cards higher, bottom cards bigger gap |
| <= 760px | Loading screen: smaller text (GLOBALITI `16vw`) |
| <= 600px | Program Keahlian / Ekstra-Kulikuler: 1 column; pop-up box max-height 80vh |
| <= 480px | Intra-Kulikuler: 1 column |

Checked in Chromium at 1440, 820, 390px: no horizontal scroll, no console errors.

## Editing content

- **Keahlian card:** copy a `.keahlian-card` (color modifier `--pplg|dkv|bd|tjkt`), new `id`, front abbreviation + back title/text, add a footer link.
- **Intra-/Ekstra card:** copy a `.kelas-card`/`.ekstra-card` + its `<template>` (subject list).
- **Person (Profil Manajemen):** copy one `li.pm-person` in its group list. Photo = `img` src, description = `.pm-desc`. Guru + Staff show the first 10; the pop-up shows all. Photos: `media/profil/`.
- **Group colors (Profil Manajemen):** `--pm-red|brown|green` and `--home-band` (navy) in `webpage.css`; strips are the band color mixed with white.
- **Hero photo:** `--hero-img` in `webpage.css`.
- **Shapes:** edit/delete the `span.deco-shape` inside a `.deco`; colors = `.deco-shape--red|blue|green|orange` (card tokens).
- **Fasilitas slide:** copy one `button.fasilitas-slide` in `index.html` (copies for the loop are made by JS).
- **Home card colors:** `--card-red|blue|green|orange|white` in `webpage.css`.
- **Naga size:** `--naga-w` in `.home-content`; zones and cards are fractions of the naga height. Phones: override in the `@media (max-width: 767px)` block after `.bottom-cards__last`.

## Pending

- Photos: `media/manajemen|kaprog|guru|staff|fasilitas/` (missing files show a label).
- Program logos; real footer description; privacy/terms URLs (`#`).
- Typos in content: "Perangakat" (PPLG), "Indsutri" (Ko-kulikuler), ".." at the end of 3 Beranda card texts (kept from the old version).
- Beranda: body text for Kurikulum Modern, Tenaga Pendidik Profesional, Fasilitas Lengkap was empty before; short text written, check it.
- Unused after the Beranda rebuild: `.section`, `.icon-circle`, `.ratio-1610` (still defined in `webpage.css`).
- Login: no backend (demo accounts in `login.js` must go); "Forgot Password?" has no page.
- Dashboards: unstyled backend templates; `/admin/...` and `/guru/...` routes need the backend.
- Existing borders kept on some Home elements (hero tags, highlight card, fasilitas). New and restyled parts (incl. Profil Manajemen) have none.
- Profil Manajemen: 3 people have no photo file yet (Sahat Parulian Verri Tampubolon, Muchamad Bagaskara, Putu Suardita); a grey slot shows. Guru list repeats the Manajemen + Kaprog people (kept from the old page, 32 photos).

## Rules check

| Rule | Status |
|------|--------|
| README updated | Yes |
| JS in `<head>` with `defer` | Yes, all pages (inline scripts moved out) |
| CSS in `webpage.css` (before login) / `dashboard.css` (after login), transitions in `animation.css` | Yes |
| Logic in `main.js` + per-page files | Yes |
| No front-end frameworks | Yes |
| No border colors on Program Sekolah, Login, navbar, footer | Yes (computed styles checked) |
| Teacher pages: border only where tasked (Main containers) | Yes (sidebar has none) |
| Containers capped on PC/laptop/tablet | Yes |
| Hamburger on tablet/phone | Yes on public pages (<= 1024px). Teacher pages: maximize icon (task override) |
| No generated icons/images | Yes |

## Changelog

### 2026-10-30 - Entry once, Beranda hero pin, shapes (codebase_24)
- Entry animations play once: `initScrollSequence` stops tracking an item once it fully entered (and removes its listeners when all are done); Program compact/full grids and Ko-kulikuler rows no longer reverse. Nothing is stored, a refresh resets them.
- Beranda hero uses the same hero pin as Program Sekolah: `.hero-pin` > `.hero-sticky` > `.home-hero`, sub-text + CTA hidden on default, revealed zoomed. Because Beranda uses it too, the JS and CSS were renamed/moved: `initProgramHeroZoom` -> `initHeroPin`, `[data-program-hero-zoom]` -> `[data-hero-pin]`, hero pin rules moved from section 8 to section 6, `.program-hero::before` -> `.hero-pin .home-hero::before`. `.hero-sticky` clips sideways only.
- Profil Manajemen: bigger gap between groups (`--pm-space-y`), shorter groups (`--pm-scale`). `.pm-content` margins became padding (same space) so shapes can sit there; the group's 40px `margin-top` is gone (the gap replaces it).
- Program Sekolah: transition top and bottom longer (+30% / +40%), `.koku-panel` full viewport width (`margin-inline: calc(50% - 50vw)`, radius 0).
- Background shapes (AI generation allowed for this task; `rules.md` still says no AI generation for other work): flat circles, rectangles, triangles on Beranda, Profil Manajemen, Program Sekolah. No scroll sequencing. Zones got `isolation: isolate` (`.home-content`, `.home-transition`, `.pm-content`, `.pm-transition-bot`, `.program`, `.program-transition-top|bot`).
- Checked in Chromium (1440, 820, 390px): all 19 pages load, no horizontal scroll, no console errors. Login and all 15 after-login pages have identical computed styles to codebase_23. Entry-once tested (scroll down, up, down; refresh resets) on Beranda, Profil, Program. Navbar still shows after 50% of the transition on all three pages.

### 2026-10-30 - Merge + structure (codebase_23)
- Merged `tefa_jlwr_codebase_22` and `Tefa-jaliwir-program-update`. Profil Manajemen page = codebase_22 version, Program Sekolah page = program-update version. Everything else was identical in both (index, login, all after-login pages, `main.js`). Media from codebase_22 (program-update had none).
- CSS: one `webpage.css` (was `main.css`) with the new Profil section 7 and the new Program section 8. Old Program dropdown CSS and old Profil "Selengkapnya" CSS are not in it. Tokens `--keahlian-*`, `--koku-teal` added. `animation.css` merged the same way (`.btn-more` and dropdown rules gone).
- JS: one `animation.js` with both hero zooms. Page files stay per page: `profil-manajemen.js` (codebase_22), `program-sekolah.js` (program-update); the old dropdown / "Selengkapnya" versions are replaced.
- Conflicts fixed: both heroes used `data-hero-zoom` and `initHeroZoom` -> Program is now `data-program-hero-zoom` / `initProgramHeroZoom`. Program Ko-kulikuler used `.seq-x`, which made the shared scroll-sequence read the wrong position -> now `data-seq-from="right"` (same as Profil); `.seq-x` CSS removed. `.program-main` got `overflow-x: clip` (side slide).
- Navbar bug (Program Sekolah): it used the plain fixed navbar. Now the same logic as Beranda and Profil: `header.navbar.navbar--float`, `[data-navbar-sentinel]` in `.program-transition-top` (now `position: relative`), no-JS fallback in `<noscript>`. Hero offset `padding-top: var(--nav-h)` removed (navbar is hidden over the hero).
- Structure: new `css/dashboard.css` = after-login CSS (old sections 10 and 11 + tokens `--sb-*`, `--status-*`) moved out of `main.css`. `main.css` renamed `webpage.css`. All pages link `webpage.css`; pages in `pages/after/` also link `dashboard.css` (after `webpage.css`). Comments and `rules.md` file names updated.
- Checked in Chromium (1440, 820, 390px): all 19 pages load, no horizontal scroll, no console errors. Computed styles of Beranda, Profil, Login and all 15 after-login pages are identical to codebase_22. Program Sekolah: navbar hidden over the hero and shown after the transition, hero zoom, flip, both pop-ups, Ko-kulikuler reveal and mobile menu tested.

### 2026-10-28 - Profil Manajemen rebuild (codebase_22)
- `profil-manajemen.html` main rebuilt (navbar + footer markup unchanged; navbar gets `.navbar--float`, same as Beranda). Old `.person` cards, "Selengkapnya" and group titles removed (old CSS removed, also `.btn-more` in `animation.css`).
- Hero: full screen, 2 states. Default = glass headline only. Scrolling pins the hero and zooms the photo a tiny bit (`--hero-p`); then the H3 + Login + Halaman fade in (zoomed state), then the page scrolls on. `js/animation.js` `initHeroZoom`, styles in `animation.css`. Reduced motion / no JS: no pin, zoomed state shown.
- Top transition: reuses `.home-transition` (hero end color to white); navbar shows after 50% of it (same sentinel as Beranda).
- Groups: Manajemen (red, 5), Kaprog (brown, 4), Guru (navy, shows 10), Staff (green, shows 10). Full-width tinted strips + colored band, photos capped by `.container`. 5 per row (tablet 5, phone 3, 2 under 360px). Photos only, no descriptions. Manajemen + Guru slide in from the right, Kaprog + Staff from the left (`data-seq-from`, translate X, scroll-sequence).
- "Cek Profil Guru" / "Cek Profil Staff": pop-up with all photos (32 / 13), 5 columns (3 on phones), rows grow and scroll, "Tutup Profil" at the bottom. Colors follow the group.
- Click a photo (page or list pop-up): pop-up with photo left, description right (same text as before). `<dialog>`; Escape closes the top one only.
- Bottom transition: empty gradient (white to footer color), footer right under it.
- New: `--pm-red|brown|green`, `.pm-*` in `main.css` section 7; `animation.js`: sideways slide + hero zoom; `profil-manajemen.js` rewritten.
- Source zip was codebase_20, so Program Sekolah is the codebase_20 version.
- Checked in Chromium (1440, 820, 390, 320px): no horizontal scroll, no console errors, both pop-ups, reduced motion and no-JS tested.

### 2026-10-26 - Beranda changes (codebase_20)
- Headline font: Anton to Montserrat Bold. `@import` + `--font-heading` in `main.css`, headings `font-weight: 700`. Applies to every page that uses `--font-heading` (checked: no overflow on Beranda, Profil, Program, Login, dashboards at 1280 and 390px). Hero headline resized (`clamp(1.9rem, 6.4vw, 5.5rem)`, no line wrap) because Montserrat is wider.
- Top cards + bottom 1st container: fade replaced by a card flip (rotate X, `animation.css`); slide up (translate Y) kept. 3D cards keep slide + fade.
- 3D cards (bottom 2nd): angle 62deg to 58deg (`--cc-angle`). Card spacing uses `--cc-half`.
- Cards a little bigger on desktop (>= 1025px): `.home-card` 34% / max 21.5rem, larger text; 3D cards 19rem x 15.5rem. Phone/tablet unchanged (min gap between cards on phones raised to 15.5rem).
- Navbar: menu centered between logo and Login (desktop). Now shows after 50% of the transition is scrolled (sentinel moved from the main content into `.home-transition`, `.navbar-sentinel`).
- Fasilitas: visible shadow on carousel cards (old warm shadow was invisible on the dark band); marquee padding raised so the shadow is not clipped.

### 2026-10-25 - Beranda rebuild (codebase_19)
- `index.html` main rebuilt: hero, transition, main content. Navbar + footer markup unchanged (navbar gets `.navbar--float`).
- Hero: full viewport (`100svh`), no navbar, per `hero-refs.png`. Login = link to `pages/login.html`. Halaman = dropdown (Beranda, Profil Manajemen, Program Sekolah) with `media/vector/dropdown.png`. 4 corner pills from the reference (decorative, one block to delete).
- Transition: empty container, gradient `--hero-end` to white.
- Main content: `media/naga-basuki.png` as background; 3 containers. Navbar shows when the content top reaches the top of the viewport (stays after).
- Top cards: Kurikulum Modern (red), Fasilitas Lengkap (blue). Bottom: Tenaga Pendidik Profesional (green), Project Based Learning (orange). Cards slide up on scroll (`[data-seq]`, `animation.js`).
- Fasilitas: right-to-left auto carousel, pauses on hover/focus, click opens full image (`<dialog>`). Same 4 photos.
- Bottom gradient white to footer color. 2 white cards (Link & Match Industri, Karakter & Soft Skills) angled 3D left/right of the naga tail, shown near the footer. Hover (desktop) / tap (mobile) slides one to the center; only one at a time (`js/cool-cards.js`).
- CSS: section 6 rewritten (old home blocks removed, `.page-hero` kept as is), new tokens, keyframes/transitions in `animation.css`. Logic in `main.js`.
- Reference borders on hero pill/Halaman button not used (rule: no border colors). Reference font not used (Anton / Plus Jakarta Sans kept).
- Checked in Chromium (1440, 820, 390px): no horizontal scroll, no console errors, dropdown, navbar, carousel pause, pop-up and 3D cards tested.

### 2026-10-22 - Login show/hide password toggle
- Added password visibility toggle button to password field on `pages/login.html`.
- Uses `eye-off.png` (hidden) and `eye-icon.png` (visible) from `media/vector/`.
- Logic implemented in `js/login.js` (`initPasswordToggle`); styles in `css/main.css` (`.login-field--password`, `.password-toggle`).

### 2026-10-21 - Soft Balance palette overhaul (after-login)
- Overhauled after-login dashboard color palette based on "Soft Balance" palette (`--sb-ivory`: `#f0efea`, `--sb-sky`: `#d3dbf0`, `--sb-gray`: `#b8b5ac`, `--sb-beige`: `#e0d2c7`, `--sb-periwinkle`: `#7a90c9`, `--sb-navy`: `#33415e`).
- Main canvas uses soft ivory backdrop (`#f5f4ef`) with crisp white cards (`#ffffff`), subtle gray/beige borders (`#ded9d1`), and navy soft shadows.
- Sidebar styled with deep navy (`#33415e`), white brand, periwinkle active page indicator (`#7a90c9`), sky-tint hover (`#dce4f4`), and frosted account container.
- Inputs, search, range, and modals updated with harmonized borders and ivory recessed fields.
- Dark mode updated to harmonized deep slate navy with ivory text and luminous periwinkle accents.

### 2026-10-19 - Admin pages
- 5 pages replace the old single Admin page: `admin-status`, `admin-piket`, `admin-rekap-siswa`, `admin-rekap-guru`, `admin-edit`. The empty `admin-rekap.html` is gone (split in two). Same sidebar, settings, Learn More, theme and topbar as the other roles. Account: "Nama Admin".
- Status Guru: same layout as the other Status Guru pages.
- Pilih Guru Piket: "Log Guru Piket" with search, filter, "Pilih Guru Piket" button; "Guru Piket Hari Ini" card (photo, name, date); log rows with edit buttons. New CSS: `.dash-feature`, `.dash-photo`.
- Pilih Guru Piket pop-up: same fields as the old pop-up (date, typeable teacher list, Berikan Akses, ATAU, Buat Kode Unik with copy and Buat kode), now in the shared pop-up styling. Close button uses a "x" character (no close icon in `media/vector`). Copy uses `clipboard-icon`, Buat kode uses `add-icon`.
- Rekap Siswa / Rekap Guru: same layout as the teacher Rekap Absensi. Edit App: main empty.
- New `admin-piket.js` (date defaults to today, placeholder code like the old page, copy).
- `dashboard.css`, `dashboard-afterlog.js` and `data-mock.js` are no longer used by any page. Not deleted.
- Checked in Chromium (1440, 1024, 820, 390, 320px): all pages load, links resolve, no horizontal scroll, no console errors.

### 2026-10-19 - Guru Piket pages
- `piket-status.html`, `piket-absen.html`, `piket-jadwal.html` replace the old single Guru Piket page (Beranda, Absen Guru and Jadwal pop-ups, Status Guru list). Same sidebar, settings, Learn More, theme and topbar as the teacher pages. Account name: "Nama Guru Piket".
- Status Guru: same layout as Siswa Status Guru (search name, filter, rows with date, green/red square on the right). Placeholders.
- Absen Guru: same layout as Guru Absen (search, filter, Mulai Absensi, log rows with edit button). Pop-up is the updated teacher form (sticky header, centered Hadir / Tidak Hadir, Hadir unchecked by default) with 36 placeholder teachers.
- Jadwal: same layout as Guru Rekap (search class, filter, rows with semester and download button). Placeholders.
- `guru-absen-siswa.js` is also loaded by `piket-absen.html` (same checkbox logic). No new CSS or JS.
- `dashboard.css`, `dashboard-afterlog.js` and `data-mock.js` are now used only by `admin/admin-status.html`. Not changed.
- Checked in Chromium (1440, 1024, 820, 390, 320px): all pages load, links resolve, no horizontal scroll, no console errors.

### 2026-10-18 - Student pages + after-login folders
- Folders now follow `codebase-structure.txt`: `pages/after/{admin,guru,guru-piket,siswa}/`.
- Renamed: `guru.html` to `guru/guru-jadwal.html`, `guru-absen-siswa.html` to `guru/guru-absen.html`, `guru-jurnal-kelas.html` to `guru/guru-jurnal.html`, `guru-rekap-absensi.html` to `guru/guru-rekap.html`. Asset paths are `../../../`, Log Out goes to `../../login.html`.
- `admin.html` moved to `admin/admin-status.html`, `guru-piket.html` to `guru-piket/piket-status.html` (content untouched, paths only). New empty pages: `admin-piket`, `admin-rekap`, `piket-absen`, `piket-jadwal`.
- `siswa.html` replaced by 3 pages (Jadwal, Status Guru, Denah Sekolah). Same sidebar, settings, Learn More, theme and topbar as the teacher pages (`.dash-*`).
- Siswa Jadwal: "Jadwal Hari Ini" rows (status square, class, zoom icon, subject + time) and a full schedule card. Same card size as the teacher Jadwal.
- Siswa Status Guru: search name + filter, rows with date and status square on the right (green/red). Placeholders.
- Siswa Denah Sekolah: main area empty.
- New CSS in section 11: `.dash-section`, `.dash-subtitle`, `.dash-card__zoom` (phone: zoom cards stay on one line).
- Kept from codebase 15: Hadir checkboxes unchecked by default.
- Not changed: `piket-status.html` still points to a missing `assets/image/jadwal-placeholder.svg` (already missing before).
- Checked in Chromium (1440, 1024, 820, 390, 320px): all pages load, links resolve, no horizontal scroll.

### 2026-10-18 - Teacher pages: closed layout, fades, fixes
- Desktop, sidebar closed: content is centered on the page (the 16rem left space is gone). Between 1025px and 1375px it starts lower so it never touches the topbar.
- Topbar fades (opacity) when the sidebar opens and closes, desktop + mobile. Mobile: faint color (sidebar color), no shadow, no border.
- Learn More (desktop): pop-up bottom matches the settings pop-up. Menu hairlines are now a background line, not a pseudo-element.
- Learn More (touch/phone): opens on click (`.is-open`), as a pop-up above the button, over the Toggle row (`z-index: 3`). Closes on second click, click elsewhere, or when settings closes.
- Mulai Absensi: rows no longer show above the sticky header (removed top padding of the scroll area). Header color marks removed. "Hadir" / "Tidak Hadir" centered on their checkboxes (the `nth-child(2)` left-align rule hit "Tidak Hadir"; now a `.dash-table__name` class).
- Tambah Jurnal: date and numbers start empty, with placeholders 1 / 2 / 1. `guru-jurnal-kelas.js` removed (it only set today's date).
- Removed unused `--dash-rail-w`.
- Checked in Chromium (1920, 1440, 1200, 1100, 820, 390px): centering, fades, alignment, pop-up positions and z-order, no console errors.

### 2026-10-18 - Teacher pages: palette, brand, mobile tools
- Teacher light mode no longer uses the warm palette. Now `--white`, `--primary-soft`, `--line`, `--ink`, `--text`, `--primary`. Warm tokens stay for Program Sekolah + Login. Dark mode text/hairlines use `--white`.
- Main containers (cards, status squares, edit/download buttons, search, buttons): shadow `0 1px 2px` (was `4px 6px 12px`) + 1px border close to the container color (`--dash-edge`). Task overrides the no-border rule here only.
- Sidebar: logo removed. Text "Globaliti Badung" in its place. Toggle icon moved top left beside it: minimize while open, maximize while closed (`.dash-topbar`). Hamburger removed (maximize icon on tablet/phone too).
- Desktop closed: content keeps 16rem on the left for the brand (`--dash-rail-w`).
- Learn More: added "Panduan Pengguna" (`href="#"`) under Syarat & Ketentuan.
- Phone (<= 600px), Absen Siswa / Jurnal Kelas / Rekap Absensi: filter icon left of a shorter search bar. Mulai Absensi / Tambah Jurnal button takes its own full-width row.
- More space between header and content (1.5rem to 2.5rem).
- `main.js`: toggle focus follows the open/close button on desktop too.
- Checked in Chromium (1440, 1024, 820, 390, 320px): no horizontal scroll, no console errors.

### 2026-10-18 - Teacher after-login pages
- 4 separate pages: Jadwal (`guru.html`), Absen Siswa, Jurnal Kelas, Rekap Absensi. Old single-page `guru.html` replaced; it no longer uses `dashboard.css`.
- Sidebar: logo (no link), page menu, account + settings. Slides left to close, right to open. Tablet/phone (<= 1024px): hamburger + drawer.
- Page menu: no border by default; ring on hover, focus and click (inset shadow). Current page = fill only.
- Settings pop-up (above the account container): Toggle Dark/Light Mode (switch), Learn More (hover sub-menu on the right, 2 `href="#"` links), Log Out (to login). No Languages.
- Dark/light mode from the existing palette; saved in `localStorage`.
- Pop-ups on the same page: Mulai Absensi (36 placeholder students, green/red checkboxes) and Tambah Jurnal (date, Jam ke- 2x1 + line, select, Pertemuan ke-, text area resizes down only).
- New: `css/main.css` section 11 + status tokens (`--status-ok`, `--status-bad`); transitions in `animation.css`; logic in `main.js`; `guru-absen-siswa.js`, `guru-jurnal-kelas.js`.
- Forms have no backend yet: Simpan only closes the pop-up (remove the `preventDefault` in `main.js` `initModals` later).
- Admin, Guru Piket and Siswa pages untouched. README left empty.
- Checked in Chromium (1440, 1024, 820, 390, 320px): no horizontal scroll, no console errors, no borders.

### 2026-10-13 - Page hero
- `.page-hero` (Profil Manajemen, Program Sekolah): headline centred vertically (equal space above and below, measured below the fixed navbar) and horizontally. Flex + `min-height`, no fixed heights.
- Program Sekolah: added page hero "PROGRAM UNGGULAN SEKOLAH" (accent on "UNGGULAN"). HTML: one `<section class="page-hero">` added.
- Removed unused `.main-offset` (the hero now clears the navbar).
- Checked in Chromium at 1440, 1100, 820, 390, 320px: no horizontal scroll, no console errors.

### 2026-10-13 - Layout fixes (`main.css` only)
- Profil Manajemen: `.page-hero` headline and body text centred; top padding now clears the fixed navbar.
- Program Keahlian: 2 x 2 grid (was 4 per row); phones keep 1 column.
- Program Keahlian cards: 3 areas - logo left, headline top right, body text bottom right.
- Intra/Ko/Ekstra: removed the `40rem` cap, tabs and lists fill the container. Removed unused `--content-max` token.
- Checked in Chromium at 1440, 1100, 820, 390, 320px: no horizontal scroll, no console errors.

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

## 2026-10-31 — Reference-inspired school preloader

- Added a shared full-screen typographic preloader across all 19 HTML pages.
- Adapted the reference composition with animated edge tickers, an outlined/fill percentage counter, progress bar, logo, and school identity.
- Added smooth upward reveal animation and same-origin HTML page transition handling, including back/forward cache restoration.
- Added responsive sizing and reduced-motion support.


### 2026-10-31 — Public preloader updated to glowing-orb reference

- Replaced the public-page typographic percentage/marquee preloader with a glowing orb that travels across an illuminated semicircular arc, inspired by the provided Pre-Loader Animation Webflow reference.
- Added a blue-to-slate gradient, large education-themed headline, loading status, and school logo/name/tagline in the footer.
- Kept the animated orb tied to page-load progress and same-site public page transitions.
- The new preloader is present only on the 4 pre-login pages: Beranda, Login, Profil Manajemen, and Program Sekolah.
- Kept all 15 after-login pages on the existing dashboard skeleton; no dashboard skeleton files or markup were changed.
- Added responsive and reduced-motion styles for the new animation.

## 2026-10-31 — DONPROD-inspired homepage intro
- Replaced the previous black/white counter loader with a cinematic photo-collage intro on `index.html` only.
- `landingsmkti.jpg` is used as the opening full-screen frame and first collage asset.
- Added `media/loading-screen/` using existing school and facility photos from `media/` because the supplied archive did not contain that folder.
- Intro plays once per tab session; internal navigation does not replay it.
- Removed preloader markup and assets from Login, Profil Manajemen, and Program Sekolah. Dashboard skeleton remains unchanged.


## 2026-10-31 — Homepage preloader reliability fix

- Fixed a cached-image initialization race that could throw before the finish logic was initialized and leave the overlay stuck.
- Counted successful and failed image loads as settled; the counter is guaranteed to reach `100` on completion or timeout.
- Added a hard timeout in `preloader.js` plus an independent HTML watchdog in `index.html` so the homepage remains accessible if the loader script fails.
- Kept the intro limited to the first `index.html` entry per tab session; internal navigation and all dashboard skeletons remain unchanged.
