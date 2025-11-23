<?php
$current_page = basename($_SERVER['PHP_SELF']); 
//$base_path = dirname($_SERVER['PHP_SELF']); 
?>


<div class="offcanvas offcanvas-start text-bg-dark" data-bs-backdrop="false" id="sidebar">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title d-flex align-items-center gap-2">
            <img src="asset/favicon-32x32.png" alt="bima32x32">
            <span class="pt-1">BIMA</span>
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <ul class="nav nav-pills flex-column mb-auto">
            <h6>Navigasi</h6>
            <li>
                <a href="index.php"
                   class="nav-link <?= ($current_page == 'index.php') ? 'active' : '' ?>">
                   <i class="bi bi-columns-gap"></i> Dashboard
                </a>
            </li>
        </ul>

        <br>

        <ul class="nav nav-pills flex-column mb-auto">
            <h6>Perkuliahan</h6>
            <li>
                <a href="jadwalKuliah.php"
                   class="nav-link <?= ($current_page == 'jadwalKuliah.php') ? 'active' : '' ?>">
                   <i class="bi bi-calendar-event"></i> Jadwal Kuliah
                </a>
            </li>
            <li>
                <a href="hasilStudi.php"
                   class="nav-link <?= ($current_page == 'hasilStudi.php') ? 'active' : '' ?>">
                   <i class="bi bi-journal-text"></i> Hasil Studi
                </a>
            </li>
            <li>
                <a href="transkripNilai.php"
                   class="nav-link <?= ($current_page == 'transkripNilai.php') ? 'active' : '' ?>">
                   <i class="bi bi-journal-check"></i> Transkrip Nilai
                </a>
            </li>
            <li>
                <a href="krs.php"
                   class="nav-link <?= ($current_page == 'krs.php') ? 'active' : '' ?>">
                   <i class="bi bi-card-checklist"></i> Pengajuan KRS
                </a>
            </li>
        </ul>

        <br>

        <ul class="nav nav-pills flex-column mb-auto">
            <h6>Dosen</h6>
            <li>
                <a href="daftarDosen.php"
                   class="nav-link <?= ($current_page == 'daftarDosen.php') ? 'active' : '' ?>">
                   <i class="bi bi-list"></i> Daftar Dosen
                </a>
            </li>
            <li>
                <a href="jadwalDosen.php"
                   class="nav-link <?= ($current_page == 'jadwalDosen.php') ? 'active' : '' ?>">
                   <i class="bi bi-calendar-event"></i> Jadwal Dosen
                </a>
            </li>
        </ul>

        <br>

        <ul class="nav nav-pills flex-column mb-auto">
            <li>
                <a href="logout.php"
                   class="nav-link <?= ($current_page == 'logout.php') ? 'active' : '' ?>">
                   <i class="bi bi-door-open"></i> Logout
                </a>
            </li>
        </ul>
    </div>
</div>
