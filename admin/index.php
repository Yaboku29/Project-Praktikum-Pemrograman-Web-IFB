<?php

// session_start();
// if(!isset($_SESSION['username'])){
//     header("Location: login.php");
//     exit();
// }
$nama = "Admin UPN";
$status = "Pengurus BIMA";
$nim = 12345;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        .content,
        #judulKonten {
            transition: margin-left 0.35s ease;
        }

        .content {
            max-height: 250px;
        }

        .shifted {
            margin-left: 300px;
        }

        #sidebar {
            /*position: fixed !important;*/
            --bs-offcanvas-width: 300px;
            height: 100vh;
            /*transform: none !important;*/
            /* hilangkan animasi offcanvas */
            visibility: visible !important;
        }

        #sidebar .nav-link {
            color: #ffffff;
            padding: 8px 12px;
            border-radius: 6px;
            transition: background 0.2s ease;
        }

        #sidebar .nav-link:hover {
            color: #000;
            background: rgba(251, 251, 251, 1);
        }

        #sidebar .nav-link.active {
            color: #000;
            background: rgba(255, 255, 255, 0.98);
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- Tombol buka sidebar -->
    <div class="d-flex align-items-center justify-content-between p-3">
        <div id="judulKonten">
            <button class="btn btn-dark m-3 text-white" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
                Menu
            </button>
        </div>

        <div>
            <h5 class="m-0"><?= $nama ?></h5>
            <h6><?= $status ?></h6>
        </div>
    </div>

    <!-- Content -->
    <div class="content" id="content">
        <!-- <div class="">
        <h1>Content Area</h1>
        <p>Ini akan bergeser dengan pas ketika sidebar terbuka.</p>
    </div> -->
        <div class="p-4 bg-light text-center py-4 border-bottom border-top">
            <h3 class="fw-bold"><?= $nama ?> <span class="text-muted">(<?= $nim ?>)</span></h3>
            <div class="text-muted">
                <!-- Fakultas Teknik Industri | Teknik Informatika | Informatika -->
            </div>
            <div class="mt-2">
                <!-- <small><i class="bi bi-person"></i> 
                <a href="" style="color: inherit; text-decoration: none;">Simon Pulung Nugroho, S.Kom., M.Cs.</a> </small> -->
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col border-bottom">
                    <h4>Informasi</h4>

                </div>
                <!-- <div class="col">
                One of three columns
                </div> -->
                <div class="col border-bottom">
                    <h4>Pengumuman</h4>
                </div>
            </div>
        </div>
    </div>


    <!-- Sidebar -->
    <div class="offcanvas offcanvas-start text-bg-dark" id="sidebar">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">
                <img src="../asset/favicon-32x32.png" alt="bima32x32"> <h5>BIMA</h5>
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">

            <ul class="nav nav-pills flex-column mb-auto">
                <h6>Navigasi</h6>
                <li><a href="#" class="nav-link active"><i class="bi bi-columns-gap"></i> Dashboard</a></li>
            </ul>
            <br>
            <ul class="nav nav-pills flex-column mb-auto">
                <h6>Kemahasiswaan</h6>
                <li><a href="register.php" class="nav-link nav-link:hover">Daftarkan Mahasiswa</a></li>
                <li><a href="#" class="nav-link nav-link:hover">Transkrip Nilai</a></li>
                <li><a href="jadwalKuliah.php?" class="nav-link nav-link:hover"><i class="bi bi-calendar-event"></i> Jadwal Kuliah</a></li>
                
            </ul>
            <br>
            <ul class="nav nav-pills flex-column mb-auto">
                <h6>Dosen</h6>
                <li><a href="daftar" class="nav-link nav-link:hover">Daftar dosen</a></li>
                <li><a href="#" class="nav-link nav-link:hover"><i class="bi bi-calendar-event"></i> Jadwal Dosen</a></li>
            </ul>
            <br>
            <ul class="nav nav-pills flex-column mb-auto">
                <h6></h6>
                <li><a href="../logout.php" class="nav-link nav-link:hover">Logout</a></li>
            </ul>
        </div>
    </div>
    <div class=""></div>



    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script untuk menggeser content -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var sidebar = document.getElementById('sidebar');
            var content = document.getElementById('content');
            var judul = document.getElementById('judulKonten')
            sidebar.addEventListener('show.bs.offcanvas', function() {
                content.classList.add('shifted');
                judul.classList.add('shifted');
            });

            sidebar.addEventListener('hide.bs.offcanvas', function() {
                content.classList.remove('shifted');
                judul.classList.remove('shifted');
            });

        });
    </script>


</body>

</html>