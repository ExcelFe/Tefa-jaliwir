/* ==========================================================================
   GURU-ABSEN-SISWA.JS - pop-up "Mulai Absensi"
   Used by: guru/guru-absen.html, guru-piket/piket-absen.html
   ========================================================================== */

/* KEHADIRAN CHECKBOXES  (green = Hadir, red = Tidak Hadir)
   One per row: checking one unchecks the other, and one always stays checked. */
function initAttendance() {
    const table = document.querySelector('.dash-table');
    if (!table) return;

    table.addEventListener('change', (event) => {
        const box = event.target.closest('.dash-check');
        if (!box) return;
        const row = box.closest('tr');
        if (box.checked) {
            row.querySelectorAll('.dash-check').forEach((other) => {
                if (other !== box) other.checked = false;
            });
        } else {
            box.checked = true;     // unchecking the active box is not allowed
        }
    });
}

initAttendance();
