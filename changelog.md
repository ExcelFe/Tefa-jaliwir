# SMK TI Bali Global Badung - School Website (`tefa_jlwr`)

Plain HTML, CSS and JavaScript. No frameworks, no build step. Rules: [`rules.md`](./rules.md). Update this README with every code change.

**Last updated: 2026-10-28**

## Pages and links

| Page | Path | Notes |
|------|------|-------|
| Beranda | `index.html` | Full-height hero, gradient transition, naga main content (6 cards, fasilitas carousel, 3D cards) |
| Profil Manajemen | `pages/before/profil-manajemen.html` | Pinned zoom hero (2 states), 4 colored groups (photos only), photo + list pop-ups |
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
├── js/    main.js (shared) | animation.js (scroll-sequence) | cool-cards.js (index) | program-sekolah.js | profil-manajemen.js | login.js | dashboard.js
├── media/ logo.webp, landingsmkti.jpg, naga-basuki.png, vector/dropdown.png, email.png, lock.png
└── pages/ login.html | before/ profil-manajemen.html, program-sekolah.html | after/ admin/ guru/ guru-piket/ siswa/
```

## CSS (`css/main.css`)

Sections: 1 Fonts, 2 Tokens, 3 Base, 4 Layout, 5 Shared components (navbar, footer), 6 Home, 7 Profil Manajemen, 8 Program Sekolah, 9 Login, 10 Dashboards, 11 Teacher dashboard (`.dash-*`). Media queries sit under each section, mobile first.

- **Fonts:** `@import` at the top of `main.css`. Headings **Montserrat Bold (700)**, body **Plus Jakarta Sans**. No font `<link>` tags.
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
| `profil-manajemen.js` | Profil Manajemen | Pop-ups: all photos of Guru/Staff, one person (photo + description) |
| `login.js` | Login | Back button |
| `dashboard.js` | `pages/after/*` | Pop-up open/close |
| `main.js` (dashboard part) | `guru/*`, `siswa/*`, `guru-piket/*`, `admin/*` | Theme switch, sidebar, settings menu (Learn More click on touch/phone), pop-ups |
| `guru-absen-siswa.js` | Absen Siswa, Absen Guru (piket) | Hadir / Tidak Hadir checkboxes |
| `admin-piket.js` | Admin Pilih Guru Piket | Today's date, placeholder code, copy button |
| `animation.js` | Home + Profil (all pages load it) | Scroll-sequence (`--seq`) for `[data-seq]`: flip (Home cards), slide up + fade (3D cards), slide from the side (`data-seq-from`, Profil groups); hero zoom (`--hero-p`, `--hero-r`, Profil) |
| `cool-cards.js` | Home | 3D cards: only one at the center |
| `main.js` (home part) | Home | Halaman dropdown, floating navbar, fasilitas carousel + pop-up |

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
- **Person (Profil Manajemen):** copy one `li.pm-person` in its group list. Photo = `img` src, description = `.pm-desc`. Guru + Staff show the first 10; the pop-up shows all. Photos: `media/profil/`.
- **Group colors (Profil Manajemen):** `--pm-red|brown|green` and `--home-band` (navy) in `main.css`; strips are the band color mixed with white.
- **Hero photo:** `--hero-img` in `main.css`.
- **Fasilitas slide:** copy one `button.fasilitas-slide` in `index.html` (copies for the loop are made by JS).
- **Home card colors:** `--card-red|blue|green|orange|white` in `main.css`.
- **Naga size:** `--naga-w` in `.home-content`; zones and cards are fractions of the naga height.

## Pending

- Photos: `media/manajemen|kaprog|guru|staff|fasilitas/` (missing files show a label).
- Program logos; real footer description; privacy/terms URLs (`#`).
- Typos in content: "Perangakat" (PPLG), "Indsutri" (Ko-kulikuler), ".." at the end of 3 Beranda card texts (kept from the old version).
- Beranda: body text for Kurikulum Modern, Tenaga Pendidik Profesional, Fasilitas Lengkap was empty before; short text written, check it.
- Unused after the Beranda rebuild: `.section`, `.icon-circle`, `.ratio-1610` (still defined in `main.css`).
- Login: no backend; "Forgot Password?" has no page.
- Dashboards: unstyled backend templates; `/admin/...` and `/guru/...` routes need the backend.
- Existing borders kept on some Home elements (hero tags, highlight card, fasilitas). New and restyled parts (incl. Profil Manajemen) have none.
- Profil Manajemen: 3 people have no photo file yet (Sahat Parulian Verri Tampubolon, Muchamad Bagaskara, Putu Suardita); a grey slot shows. Guru list repeats the Manajemen + Kaprog people (kept from the old page, 32 photos).

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
