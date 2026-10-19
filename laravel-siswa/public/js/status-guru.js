/* =========================================================
   STATUS GURU - ambil data absen guru dari server (per tanggal)
   Dipakai di: resources/views/dashboard/siswa.blade.php
   Endpoint  : data-endpoint pada <ul id="status-guru">
   Template  : <template id="tpl-guru-status"> (placeholder {{...}})
   ========================================================= */
(function () {
  'use strict';

  var list = document.getElementById('status-guru');
  var input = document.getElementById('filter-tanggal');
  var btnToday = document.getElementById('btn-hari-ini');
  var tplEl = list && document.getElementById(list.dataset.template);
  if (!list || !input || !tplEl || !list.dataset.endpoint) return;

  var url = list.dataset.endpoint;
  var today = input.dataset.hariIni || input.value;
  var tpl = tplEl.innerHTML;
  var reqId = 0;

  function esc(v) {
    return String(v == null ? '' : v).replace(/[&<>"']/g, function (c) {
      return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
    });
  }
  function fill(item) {
    return tpl.replace(/\{\{(\w+)\}\}/g, function (_, k) { return esc(item[k]); });
  }
  function message(text) {
    list.innerHTML = '<p class="empty">' + esc(text) + '</p>';
  }
  /* kalau kolom cari sedang terisi, terapkan lagi ke data baru */
  function reapplySearch() {
    var s = document.querySelector('[data-filter="#status-guru"]');
    if (s && s.value) s.dispatchEvent(new Event('input', { bubbles: true }));
  }

  function load() {
    if (!input.value) input.value = today;
    var my = ++reqId;
    message('Memuat data...');

    fetch(url + '?tanggal=' + encodeURIComponent(input.value), {
      headers: { Accept: 'application/json' },
      credentials: 'same-origin'
    })
      .then(function (r) { if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); })
      .then(function (items) {
        if (my !== reqId) return;               // abaikan respon lama
        if (!items.length) { message('Belum ada data absen guru pada tanggal ini.'); return; }
        list.innerHTML = items.map(fill).join('');
        reapplySearch();
      })
      .catch(function (err) {
        if (my !== reqId) return;
        console.warn('Gagal memuat status guru:', err);
        message('Gagal memuat data. Coba muat ulang halaman.');
      });
  }

  input.addEventListener('change', load);
  if (btnToday) btnToday.addEventListener('click', function () { input.value = today; load(); });

  load();
})();