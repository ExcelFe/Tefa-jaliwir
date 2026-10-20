# SMK TI Bali Global Badung - School Website (`tefa_jlwr`)

Plain HTML, CSS and JavaScript. No frameworks, no build step. Rules: [`rules.md`](./rules.md). Update this README with every code change.

**Last updated: 2026-10-18**

## Pages and links

| Page | Path | Notes |
|------|------|-------|
| Beranda | `index.html` | Hero, highlight card, kurikulum, fasilitas |
| Profil Manajemen | `pages/before/profil-manajemen.html` | 4 groups, "Selengkapnya" buttons |
| Program Sekolah | `pages/before/program-sekolah.html` | Warm theme, dropdown tabs |
| Login | `pages/login.html` | Warm theme, logo left / form right, no backend |
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
└── pages/ login.html | before/ profil-manajemen.html, program-sekolah.html | after/ admin/ guru/ guru-piket/ siswa/
```

## CSS (`css/main.css`)

Sections: 1 Fonts, 2 Tokens, 3 Base, 4 Layout, 5 Shared components (navbar, footer), 6 Home, 7 Profil Manajemen, 8 Program Sekolah, 9 Login, 10 Dashboards, 11 Teacher dashboard (`.dash-*`). Media queries sit under each section, mobile first.

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
| `main.js` (dashboard part) | `guru/*`, `siswa/*`, `guru-piket/*`, `admin/*` | Theme switch, sidebar, settings menu (Learn More click on touch/phone), pop-ups |
| `guru-absen-siswa.js` | Absen Siswa, Absen Guru (piket) | Hadir / Tidak Hadir checkboxes |
| `admin-piket.js` | Admin Pilih Guru Piket | Today's date, placeholder code, copy button |
| `animation.js` | Home, Profil, Program, Login | Empty (JS animations go here) |

## Program Sekolah

Starts with a page hero (same `.page-hero` as Profil Manajemen). Each block: headline first, content below. Tabs closed on load; list opens under the tab row. Intra/Ko/Ekstra tabs and lists fill the full container width.

**Program Keahlian:** 2 x 2 grid (1 column on phones). Each card has 3 areas (CSS grid areas, no extra HTML): logo left (full height), headline top right, body text bottom right. Cards use abbreviation placeholders (TJKT, PPLG, DKV, BD); swap the `<span>` for an `<img>` when logos exist.

## Login

Card = 2 columns (logo + school name | back button, headline, form). One column at <= 768px. Gradients mix navy, blue, cyan and warm cream. Inputs unchanged: email, password.

## Responsive

| Width | Changes |
|-------|---------|
| >= 1025px | Full navbar (menu centred) |
| <= 1024px | Hamburger menu |
| >= 600px | Program Keahlian 2 x 2 |
| <= 768px | Login stacks; hero centred |
| <= 600px | Program Keahlian 1 column; ekstra tabs 2 x 2 |
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
| Teacher pages: border only where tasked (Main containers) | Yes (sidebar has none) |
| Containers capped on PC/laptop/tablet | Yes |
| Hamburger on tablet/phone | Yes on public pages (<= 1024px). Teacher pages: maximize icon (task override) |
| No generated icons/images | Yes |

## Changelog

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
