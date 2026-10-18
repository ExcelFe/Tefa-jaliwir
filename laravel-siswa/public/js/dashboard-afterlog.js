/* =========================================================
   SMK TI Bali Global Badung - dashboard.js (vanilla JS)
   Isi: sidebar, popup, render data, carousel, pilih kelas,
        filter pencarian, zoom jadwal, salin kode, upload foto
   ========================================================= */
(function () {
  'use strict';
  var D = window.TEFA_DATA || {};
  var $  = function (s, r) { return (r || document).querySelector(s); };
  var $$ = function (s, r) { return Array.prototype.slice.call((r || document).querySelectorAll(s)); };
  var STATUS = { hadir: ['ok', 'Hadir'], tidak: ['bad', 'Tidak Hadir'], izin: ['warn', 'Izin'], sakit: ['warn', 'Sakit'] };

  /* ---------- helper: isi template dengan data ----------
     <template id="x">... {{nama}} ...</template>
     <ul data-render="guruStatus" data-template="x" data-endpoint="/api/guru"> */
  function esc(v) { return String(v == null ? '' : v).replace(/[&<>"']/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]; }); }
  function fill(tpl, item, i) {
    item = Object.assign({ no: i + 1 }, item);
    if (item.status && STATUS[item.status]) { item.statusClass = STATUS[item.status][0]; item.statusLabel = item.statusLabel || STATUS[item.status][1]; }
    return tpl.replace(/\{\{(\w+)\}\}/g, function (_, k) { return esc(item[k]); });
  }
  function cleanImgs(root) {
    $$('img', root).forEach(function (img) {
      if (!img.getAttribute('src')) { img.remove(); return; }
      img.addEventListener('error', function () { img.remove(); });
    });
  }
  function render(el, ctx) {
    var tpl = document.getElementById(el.dataset.template);
    if (!tpl) return;
    function pick() {
      var d = D[el.dataset.render];
      if (d && !Array.isArray(d)) d = d[ctx && ctx.kelas] || d['default'];
      return d || [];
    }
    function done(items) {
      el.innerHTML = items.length ? items.map(function (it, i) { return fill(tpl.innerHTML, it, i); }).join('')
                                  : '<p class="empty">Belum ada data.</p>';
      cleanImgs(el);
      el.dispatchEvent(new CustomEvent('rendered', { bubbles: true }));
    }
    var url = el.dataset.endpoint;
    if (url) {
      url = url.replace('{kelas}', encodeURIComponent((ctx && ctx.kelas) || ''));
      fetch(url, { headers: { Accept: 'application/json' } })
        .then(function (r) { return r.json(); }).then(done)
        .catch(function () { console.warn('Gagal memuat ' + url + ', memakai data contoh.'); done(pick()); });
    } else { done(pick()); }
  }

  /* ---------- sidebar ---------- */
  var sidebar = $('#sidebar'), overlay = $('#overlay');
  function sidebarToggle(open) {
    if (!sidebar) return;
    sidebar.classList.toggle('is-open', open);
    overlay.classList.toggle('is-open', open);
    document.body.classList.toggle('no-scroll', open);
  }

  /* ---------- popup + langkah (step) ---------- */
  function showStep(m, name) { $$('.step', m).forEach(function (s) { s.hidden = s.dataset.step !== name; }); }
  function openModal(id) {
    var m = document.getElementById(id); if (!m) return;
    sidebarToggle(false);
    m.hidden = false; document.body.classList.add('no-scroll');
    var first = $('.step', m); if (first) showStep(m, first.dataset.step);
    $$('[data-zoom]', m).forEach(function (z) { z.dispatchEvent(new Event('zoomreset')); });
  }
  function closeModal(m) {
    m.hidden = true;
    if (!$$('.modal').some(function (x) { return !x.hidden; })) document.body.classList.remove('no-scroll');
  }

  /* ---------- pilih kelas (accordion Kelas X / XI / XII) ---------- */
  function buildPicker(p) {
    var data = D.kelas || {}, tabs = $('.tabs', p), lists = $('.class-groups', p), open = p.dataset.open;
    tabs.innerHTML = ''; lists.innerHTML = '';
    Object.keys(data).forEach(function (k) {
      var t = document.createElement('button');
      t.type = 'button'; t.className = 'tab'; t.dataset.group = k;
      t.setAttribute('aria-expanded', String(k === open));
      t.innerHTML = '<span>Kelas ' + esc(k) + '</span><i class="fa-solid ' + (k === open ? 'fa-minus' : 'fa-plus') + '"></i>';
      tabs.appendChild(t);
      var g = document.createElement('div');
      g.className = 'class-list'; g.dataset.group = k; g.hidden = k !== open;
      g.innerHTML = data[k].map(function (n) { return '<button type="button" class="row-btn" data-kelas="' + esc(n) + '"><span>' + esc(n) + '</span><i class="fa-solid fa-chevron-right"></i></button>'; }).join('');
      lists.appendChild(g);
    });
  }
  function chooseClass(btn) {
    var m = btn.closest('.modal'), p = btn.closest('.class-picker'), kelas = btn.dataset.kelas;
    $$('[data-slot="kelas-nama"]', m).forEach(function (e) { e.textContent = kelas; });
    $$('[data-kelas-input]', m).forEach(function (e) { e.value = kelas; });
    showStep(m, p.dataset.next);
    $$('[data-render][data-lazy]', m).forEach(function (el) { render(el, { kelas: kelas }); });
  }

  /* ---------- carousel ---------- */
  function carousel(root) {
    var track = $('.car-track', root), dotsBox = $('.car-dots', root), slides = $$('.slide', track), i = 0;
    dotsBox.innerHTML = '';
    if (!slides.length) { $$('.car-btn', root).forEach(function (b) { b.hidden = true; }); return; }
    slides.forEach(function (s, n) {
      if (s.dataset.active === '1') i = n;
      var d = document.createElement('button'); d.type = 'button'; d.setAttribute('aria-label', 'Jadwal ' + (n + 1));
      d.addEventListener('click', function () { go(n); }); dotsBox.appendChild(d);
    });
    function go(n) {
      i = (n + slides.length) % slides.length;
      track.style.transform = 'translateX(-' + (i * 100) + '%)';
      $$('button', dotsBox).forEach(function (d, k) { d.classList.toggle('is-on', k === i); });
    }
    root._go = function (step) { go(i + step); };
    go(i);
  }

  /* ---------- zoom jadwal ---------- */
  function zoom(root) {
    var frame = $('.zoom-frame', root), stage = $('.zoom-stage', root), lvl = $('.zoom-level', root), s = 1, x = 0, y = 0, drag = null;
    function apply() { stage.style.transform = 'translate(-50%,-50%) translate(' + x + 'px,' + y + 'px) scale(' + s + ')'; lvl.textContent = Math.round(s * 100) + '%'; }
    function set(v) { s = Math.min(4, Math.max(0.5, v)); if (s <= 1) { x = 0; y = 0; } apply(); }
    root.addEventListener('zoomreset', function () { s = 1; x = 0; y = 0; apply(); });
    root.addEventListener('click', function (e) {
      var b = e.target.closest('[data-zoom-in],[data-zoom-out],[data-zoom-reset]'); if (!b) return;
      if (b.hasAttribute('data-zoom-in')) set(s + 0.25); else if (b.hasAttribute('data-zoom-out')) set(s - 0.25); else { s = 1; x = 0; y = 0; apply(); }
    });
    frame.addEventListener('wheel', function (e) { e.preventDefault(); set(s + (e.deltaY < 0 ? 0.15 : -0.15)); }, { passive: false });
    frame.addEventListener('pointerdown', function (e) { drag = { px: e.clientX, py: e.clientY, x: x, y: y }; frame.setPointerCapture(e.pointerId); frame.classList.add('drag'); });
    frame.addEventListener('pointermove', function (e) { if (!drag) return; x = drag.x + e.clientX - drag.px; y = drag.y + e.clientY - drag.py; apply(); });
    ['pointerup', 'pointercancel'].forEach(function (t) { frame.addEventListener(t, function () { drag = null; frame.classList.remove('drag'); }); });
    apply();
  }

  /* ---------- klik (delegasi) ---------- */
  document.addEventListener('click', function (e) {
    var t = e.target, el;
    if ((el = t.closest('[data-sidebar-open]')))  return sidebarToggle(true);
    if (t.closest('[data-sidebar-close]') || t === overlay) return sidebarToggle(false);
    if ((el = t.closest('[data-modal-open]')))    { e.preventDefault(); return openModal(el.dataset.modalOpen); }
    if (t.closest('[data-modal-close]') || t.classList.contains('modal')) return closeModal(t.closest('.modal'));
    if ((el = t.closest('[data-step-go]')))       return showStep(el.closest('.modal'), el.dataset.stepGo);

    if ((el = t.closest('.class-picker .tab'))) {
      var p = el.closest('.class-picker'), willOpen = el.getAttribute('aria-expanded') !== 'true';
      $$('.tab', p).forEach(function (b) { var on = willOpen && b === el; b.setAttribute('aria-expanded', String(on)); $('i', b).className = 'fa-solid ' + (on ? 'fa-minus' : 'fa-plus'); });
      $$('.class-list', p).forEach(function (g) { g.hidden = !(willOpen && g.dataset.group === el.dataset.group); });
      return;
    }
    if ((el = t.closest('.row-btn[data-kelas]'))) return chooseClass(el);

    if ((el = t.closest('.car-btn'))) { var c = el.closest('[data-carousel]'); return c._go && c._go(el.dataset.dir === 'prev' ? -1 : 1); }

    if ((el = t.closest('[data-dd-toggle]'))) { var m = el.nextElementSibling; m.hidden = !m.hidden; return; }
    $$('.dd-menu').forEach(function (m) { if (!m.parentNode.contains(t)) m.hidden = true; });

    if ((el = t.closest('.dl-toggle'))) {
      var sub = el.closest('.dl').querySelector('.dl-sub'), show = sub.hidden;
      sub.hidden = !show; $('i', el).className = 'fa-solid ' + (show ? 'fa-minus' : 'fa-plus'); el.setAttribute('aria-expanded', String(show)); return;
    }
    if ((el = t.closest('[data-gen-code]'))) {
      var out = document.getElementById(el.dataset.genCode);
      out.value = 'PKT-' + Math.random().toString(36).slice(2, 8).toUpperCase() + '-' + Date.now().toString(36).slice(-3).toUpperCase(); return;
    }
    if ((el = t.closest('.copy-btn'))) {
      var f = document.getElementById(el.dataset.copy); if (!f || !f.value) return;
      (navigator.clipboard ? navigator.clipboard.writeText(f.value) : Promise.reject()).catch(function () { f.select(); document.execCommand('copy'); });
      var ic = $('i', el); ic.className = 'fa-solid fa-check'; setTimeout(function () { ic.className = 'fa-regular fa-copy'; }, 1400);
    }
  });
  document.addEventListener('keydown', function (e) {
    if (e.key !== 'Escape') return;
    sidebarToggle(false); $$('.modal').forEach(function (m) { if (!m.hidden) closeModal(m); });
  });

  /* ---------- pencarian: <input data-filter="#id-kontainer"> ---------- */
  document.addEventListener('input', function (e) {
    var inp = e.target.closest('[data-filter]'); if (!inp) return;
    var q = inp.value.trim().toLowerCase();
    $$(inp.dataset.filter + ' .list-row,' + inp.dataset.filter + ' [data-row]').forEach(function (r) { r.hidden = q && r.textContent.toLowerCase().indexOf(q) === -1; });
  });

  /* ---------- preview foto jurnal ---------- */
  document.addEventListener('change', function (e) {
    var inp = e.target.closest('.upload input[type=file]'); if (!inp || !inp.files[0]) return;
    var box = inp.closest('.upload'), old = $('img', box); if (old) old.remove();
    var img = document.createElement('img'); img.alt = 'Pratinjau foto'; img.src = URL.createObjectURL(inp.files[0]); box.appendChild(img);
  });

  /* ---------- inisialisasi ---------- */
  document.addEventListener('DOMContentLoaded', function () {
    var local = new Date(Date.now() - new Date().getTimezoneOffset() * 60000).toISOString().slice(0, 10);
    $$('input[type=date][data-today]').forEach(function (i) { i.value = local; });
    if (D.user) $$('[data-slot^="user-"]').forEach(function (e) { e.textContent = D.user[e.dataset.slot.slice(5)] || e.textContent; });
    $$('.class-picker').forEach(buildPicker);
    /* listener carousel harus dipasang SEBELUM data dirender */
    $$('[data-carousel]').forEach(function (c) { $('.car-track', c).addEventListener('rendered', function () { carousel(c); }); });
    $$('[data-render]:not([data-lazy])').forEach(function (el) { render(el); });
    $$('[data-zoom]').forEach(zoom);
  });
})();

    /* ========================= */
    /* SCRIPT POPUP MODAL LOGOUT */
    /* ========================= */
        const logoutTrigger = document.getElementById('logoutTrigger');
        const logoutModal = document.getElementById('logoutModal');
        const cancelLogout = document.getElementById('cancelLogout');
        const confirmLogout = document.getElementById('confirmLogout');

        // Tampilkan modal saat tombol "Keluar" diklik
        logoutTrigger.addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah link me-refresh halaman
            logoutModal.classList.add('show');
        });

        // Sembunyikan modal saat tombol "Tidak" diklik
        cancelLogout.addEventListener('click', function() {
            logoutModal.classList.remove('show');
        });

        // Sembunyikan modal jika pengguna mengklik area gelap (overlay) di luar kotak
        window.addEventListener('click', function(event) {
            if (event.target === logoutModal) {
                logoutModal.classList.remove('show');
            }
        });

        // Aksi saat tombol "Ya" diklik
        // Aksi saat tombol "Ya" diklik
if (confirmLogout) {
    confirmLogout.addEventListener('click', function() {
        // Biarkan form melakukan submit POST ke route logout Laravel
        logoutModal.classList.remove('show');
    });
}
