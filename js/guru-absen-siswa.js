/* ==========================================================================
   GURU-ABSEN-SISWA.JS - pop-up "Mulai Absensi"
   Used by: guru/guru-absen.html, guru-piket/piket-absen.html
   ========================================================================== */

/* KEHADIRAN CHECKBOXES & NIHIL TOGGLE
   - Green = Hadir, Red = Tidak Hadir
   - Checking one unchecks the other within the row
   - Checkbox "Nihil": jika dicentang, seluruh siswa ditandai Hadir
   - Jika Nihil di-uncheck: seluruh pilihan kehadiran siswa direset (dikosongkan)
   - Jika salah satu siswa diubah jadi Tidak Hadir, checkbox Nihil otomatis uncheck */
function initAttendance() {
    const table = document.querySelector('.dash-table');
    const nihilCheckbox = document.getElementById('check-nihil');
    if (!table) return;

    // Fungsi untuk memperbarui status checkbox Nihil berdasarkan baris kehadiran
    const updateNihilState = () => {
        if (!nihilCheckbox) return;
        const rows = table.querySelectorAll('tbody tr');
        if (!rows.length) return;
        let allHadir = true;
        rows.forEach((row) => {
            const okBox = row.querySelector('.dash-check--ok');
            if (!okBox || !okBox.checked) {
                allHadir = false;
            }
        });
        nihilCheckbox.checked = allHadir;
    };

    // Hanya satu status (Hadir / Sakit / Izin) yang boleh aktif per siswa.
    // Input status di HTML memakai radio; handler ini menjaga aturan yang sama
    // dan tetap aman jika ada input checkbox lama di dalam tabel.
    table.addEventListener('change', (event) => {
        const box = event.target;
        if (!(box instanceof HTMLInputElement) || !box.matches('input.dash-check')) return;

        const row = box.closest('tbody tr');
        if (!row) return;

        if (box.checked) {
            row.querySelectorAll('input.dash-check[name^="kehadiran["]').forEach((other) => {
                if (other !== box) other.checked = false;
            });
        }
        updateNihilState();
    });

    // Checkbox Nihil: jika centang -> semua Hadir, jika uncentang -> reset (semua centang dilepas)
    if (nihilCheckbox) {
        nihilCheckbox.addEventListener('change', () => {
            const rows = table.querySelectorAll('tbody tr');
            if (nihilCheckbox.checked) {
                rows.forEach((row) => {
                    const okBox = row.querySelector('.dash-check--ok');
                    const badBox = row.querySelector('.dash-check--bad');
                    if (okBox) okBox.checked = true;
                    if (badBox) badBox.checked = false;
                });
            } else {
                // Reset semua kehadiran siswa ke kondisi awal kosong
                rows.forEach((row) => {
                    row.querySelectorAll('.dash-check').forEach((check) => {
                        check.checked = false;
                    });
                });
            }
        });
        // Inisialisasi awal status Nihil
        updateNihilState();
    }
}

/* WIZARD TAHAPAN MULAI ABSENSI (Step 1: Angkatan/Kelas -> Step 2: Jurusan -> Step 3: Form Absensi) */
function initAbsenWizard() {
    const modal = document.getElementById('modal-absen');
    if (!modal) return;

    const modalTitle = document.getElementById('modal-absen-title');
    const stepKelas = document.getElementById('step-kelas');
    const stepJurusan = document.getElementById('step-jurusan');
    const stepForm = document.getElementById('step-form');
    const stepNavFooter = document.getElementById('step-nav-footer');
    const btnModalBack = document.getElementById('btn-modal-back');
    const btnStepPrev = document.getElementById('btn-step-prev');
    const btnBackStep = document.getElementById('btn-back-step');
    const selectedKelasLabel = document.getElementById('selected-kelas-label');
    const absenTargetClass = document.getElementById('absen-target-class');

    // Jika elemen wizard tidak ada (misal di piket-absen.html), jangan jalankan
    if (!stepKelas || !stepJurusan || !stepForm) return;

    let selectedKelas = '';
    let selectedJurusan = '';
    let currentStep = 1;

    const goToStep = (step) => {
        currentStep = step;
        stepKelas.classList.toggle('is-active', step === 1);
        stepJurusan.classList.toggle('is-active', step === 2);
        stepForm.classList.toggle('is-active', step === 3);

        if (step === 1) {
            if (modalTitle) modalTitle.textContent = 'Pilih Angkatan / Kelas';
            if (stepNavFooter) stepNavFooter.style.display = 'flex';
            if (btnStepPrev) btnStepPrev.style.display = 'none';
            if (btnModalBack) btnModalBack.style.display = 'none';
        } else if (step === 2) {
            if (modalTitle) modalTitle.textContent = 'Pilih Jurusan';
            if (selectedKelasLabel) selectedKelasLabel.textContent = `Kelas ${selectedKelas}`;
            if (stepNavFooter) stepNavFooter.style.display = 'flex';
            if (btnStepPrev) btnStepPrev.style.display = 'inline-flex';
            if (btnModalBack) btnModalBack.style.display = 'inline-flex';
        } else if (step === 3) {
            if (modalTitle) modalTitle.textContent = `Mulai Absensi - Kelas ${selectedKelas} ${selectedJurusan}`;
            if (absenTargetClass) absenTargetClass.textContent = `Kelas ${selectedKelas} ${selectedJurusan}`;
            if (stepNavFooter) stepNavFooter.style.display = 'none';
            if (btnModalBack) btnModalBack.style.display = 'inline-flex';
        }
    };

    // Tombol Back di Header Modal (berlaku untuk Step 2 -> Step 1, dan Step 3 -> Step 2)
    if (btnModalBack) {
        btnModalBack.addEventListener('click', () => {
            if (currentStep === 3) {
                goToStep(2);
            } else if (currentStep === 2) {
                goToStep(1);
            }
        });
    }

    // Handler klik tombol pilihan Kelas
    modal.querySelectorAll('[data-select-kelas]').forEach((btn) => {
        btn.addEventListener('click', () => {
            selectedKelas = btn.getAttribute('data-select-kelas');
            goToStep(2);
        });
    });

    // Handler klik tombol pilihan Jurusan
    modal.querySelectorAll('[data-select-jurusan]').forEach((btn) => {
        btn.addEventListener('click', () => {
            selectedJurusan = btn.getAttribute('data-select-jurusan');
            goToStep(3);
        });
    });

    // Tombol Kembali di Step 2 (kembali ke Step 1)
    if (btnStepPrev) {
        btnStepPrev.addEventListener('click', () => {
            goToStep(1);
        });
    }

    // Tombol Kembali di Footer Step 3 (kembali ke Step 2)
    if (btnBackStep) {
        btnBackStep.addEventListener('click', () => {
            goToStep(2);
        });
    }

    // Reset wizard setiap kali tombol pemicu modal "Mulai Absensi" diklik
    document.querySelectorAll('[data-modal-open="modal-absen"]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            goToStep(1);
        });
    });
}

initAttendance();
initAbsenWizard();

