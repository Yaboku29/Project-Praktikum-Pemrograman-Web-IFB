<?php

// session_start();
// if(!isset($_SESSION['username'])){
//     header("Location: login.php");
//     exit();
// }
$nama="Ananda Rizky Setya Nugroho";
$status="Mahasiswa";
$nim=123240070;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">

    <style>
        .content, #judulKonten {
            transition: margin-left 0.35s ease;
        }
        .content{
            max-height: 250px;
        }

        .shifted {
            margin-left: 200px;
        }

        #sidebar {
            /*position: fixed !important;*/
            --bs-offcanvas-width: 200px;
            height: 100vh;
            /*transform: none !important;*/
            /* hilangkan animasi offcanvas */
            visibility: visible !important;
        }
    </style>
</head>

<body>
    <!-- Tombol buka sidebar -->
    <div class="d-flex align-items-center justify-content-between p-3">
        <div id="judulKonten">
            <button class="btn btn-primary m-3" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
                Menu
            </button>
        </div>

        <div>
            <h5 class="m-0" ><?=$nama?></h5>
            <h6><?=$status?></h6>
        </div>
    </div>

    <!-- Content -->
    <div class="content" id="content">
    <!-- <div class="">
        <h1>Content Area</h1>
        <p>Ini akan bergeser dengan pas ketika sidebar terbuka.</p>
    </div> -->
        <div class="p-4 bg-light text-center py-4 border-bottom border-top" >
            <h3 class="fw-bold"><?=$nama?> <span class="text-muted">(<?=$nim?>)</span></h3>
            <div class="text-muted">
                Fakultas Teknik Industri | Teknik Informatika | Informatika
            </div>
            <div class="mt-2">
                <small><i class="bi bi-person"></i> Simon Pulung Nugroho, S.Kom., M.Cs.</small>
            </div>
        </div>
    </div> 
    

    <!-- Sidebar -->
    <div class="offcanvas offcanvas-start text-bg-dark" id="sidebar">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">
                <img src="asset/favicon-32x32.png" alt="bima32x32">BIMA</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            
            <ul class="nav nav-pills flex-column mb-auto">
                <h6>Navigasi</h6>
                <li><a href="#" class="nav-link text-white">Dashboard</a></li>
            </ul>
            <br>
            <ul class="nav nav-pills flex-column mb-auto">
                <h6>Perkuliahan</h6>    
                <li><a href="#" class="nav-link text-white">Nilai</a></li>
                <li><a href="#" class="nav-link text-white">Transkrip Nilai</a></li>
                <li><a href="daftar" class="nav-link text-white">Daftar dosen</a></li>
                <li><a href="jadwalKuliah.php?" class="nav-link text-white">jadwal Kuliah</a></li>
            </ul>
            <br>
            <ul class="nav nav-pills flex-column mb-auto">
                <h6>Dosen</h6>
                <li><a href="#" class="nav-link text-white">Jadwal Dosen</a></li>
            </ul>
            <br>
            <ul class="nav nav-pills flex-column mb-auto">
                <h6></h6>
                <li><a href="logout.php" class="nav-link text-white">Logout</a></li>
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
            var judul   = document.getElementById('judulKonten')
            sidebar.addEventListener('show.bs.offcanvas', function () {
                content.classList.add('shifted');
                judul.classList.add('shifted');
            });

            sidebar.addEventListener('hide.bs.offcanvas', function () {
                content.classList.remove('shifted');
                judul.classList.remove('shifted');
            });

        });
    </script>


</body>

</html>