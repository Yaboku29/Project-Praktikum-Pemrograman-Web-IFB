<?php
/*
session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}
*/
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">

    <style>
        .content {
            transition: margin-left 0.3s;
        }

        .content.shifted {
            margin-left: 250px;
            /* Lebar sidebar */
        }

        #sidebar.is-open {
            position: fixed !important;
            width: 250px;
            height: 100vh;
            transform: none !important;
            /* hilangkan animasi offcanvas */
            visibility: visible !important;
        }
    </style>
</head>

<body>

    <div>
        
    </div>
    

    <!-- Tombol buka sidebar -->
    <div class="d-flex align-items-center p-3">
        <div>
            <button class="btn btn-primary m-3" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
                Menu
            </button>
        </div>

        <div class="flex-grow-1 text-center" id="judulKonten">
            <h1 class="m-0" >BIMA KW</h1>
        </div>

        <div style="width: 48px;"></div>
    </div>


    <!-- <button class="btn btn-primary m-3" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
        Menu
    </button> -->
    <!-- Content -->
    <div class="p-4 content" id="content">
        <h1>Content Area</h1>
        <p>Ini akan bergeser dengan pas ketika sidebar terbuka.</p>
    </div>

    <!-- Sidebar -->
    <div class="offcanvas offcanvas-start text-bg-dark" id="sidebar">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Sidebar</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav nav-pills flex-column mb-auto">
                <li><a href="#" class="nav-link text-white">Home</a></li>
                <li><a href="#" class="nav-link text-white">Nilai</a></li>
                <li><a href="#" class="nav-link text-white">Transkrip Nilai</a></li>
                <li><a href="#" class="nav-link text-white">Daftar dosen</a></li>
                <li><a href="#" class="nav-link text-white">jadwal Kuliah</a></li>
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
            sidebar.addEventListener('shown.bs.offcanvas', function() {
                sidebar.classList.add('is-open');
                content.style.marginLeft = "250px";
                judul.style.marginLeft = "250px";

            });

            sidebar.addEventListener('hidden.bs.offcanvas', function() {
                sidebar.classList.remove('is-open');
                content.style.marginLeft = "0";
                judul.style.marginLeft = "0";
            });
        });
    </script>


</body>

</html>