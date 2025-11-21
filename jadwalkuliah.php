<?php

session_start();
require 'config/db.php';
// if(!isset($_SESSION['username'])){
//     header("Location: login.php");
//     exit();
// }
//$nim=$_SESSION['username'];
$nim='123240087';
$sql_user = "SELECT idUser,nama 
             FROM users 
             WHERE username = ? 
             LIMIT 1";

$stmt_user = $db->prepare($sql_user);
$stmt_user->bind_param("s", $nim);
$stmt_user->execute();
$res_user = $stmt_user->get_result();

if ($res_user->num_rows === 0) {
    die("User tidak ditemukan!");
}

$user = $res_user->fetch_assoc();
$id_user = $user['idUser'];
$nama=$user['nama'];

//ambil semester
$sql_sem = "SELECT semester 
            FROM krs
            WHERE idUser = ?
            ORDER BY semester DESC
            LIMIT 1";

$stmt_sem = $db->prepare($sql_sem);
$stmt_sem->bind_param("i", $id_user);
$stmt_sem->execute();
$s = $stmt_sem->get_result();

if ($s->num_rows == 0) die("Belum ada KRS!");

$semester_sekarang = $s->fetch_assoc()['semester'];

//ambil jadwal
$sql_jadwal = "SELECT 
                kls.nama_kelas,
                kls.sks,
                kls.hari,
                kls.jam_mulai,
                kls.jam_selesai,
                kls.ruangan 
                FROM krs AS k 
                JOIN krs_details AS kd ON kd.id_krs = k.idKRS 
                JOIN kelas AS kls ON kls.id = kd.id_kelas 
                WHERE k.idUser = ? AND k.semester = kd.semester AND k.semester=? 
                ORDER BY FIELD(kls.hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')";

$stmt_jadwal = $db->prepare($sql_jadwal);
$stmt_jadwal->bind_param("ii", $id_user, $semester_sekarang);
$stmt_jadwal->execute();
$jadwal = $stmt_jadwal->get_result();


// $nama = "Ananda Rizky Setya Nugroho";
$status = "Mahasiswa";
// $nim = 123240070;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kuliah</title>
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
    <div class="d-flex align-items-center justify-content-between px-3 pt-2">
        <div id="judulKonten">
            <button class="btn btn-dark m-0 text-white px-3 py-2" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
                <i class="bi bi-layout-sidebar"></i>
            </button>
        </div>

        <div class="">
            <h5 class="m-0"><?= $nama ?></h5>
            <h6 class=""><?= $status ?></h6>
            <a href="profile.php" class="btn btn-dark text-white" style="color: inherit; text-decoration: none;">Profile</a>
        </div>
    </div>
    <br>
    <!-- Content -->
    <div class="content" id="content">
        <!-- <div class="">
        <h1>Content Area</h1>
        <p>Ini akan bergeser dengan pas ketika sidebar terbuka.</p>
    </div> -->
        <!-- <div class="p-4 bg-light text-center py-4 border-bottom border-top">
            <h3 class="fw-bold"><?= $nama ?> <span class="text-muted">(<?= $nim ?>)</span></h3>
            <div class="text-muted">
                Fakultas Teknik Industri | Teknik Informatika | Informatika
            </div>
            <div class="mt-2">
                <small><i class="bi bi-person"></i>
                    <a href="" style="color: inherit; text-decoration: none;">Simon Pulung Nugroho, S.Kom., M.Cs.</a> </small>
            </div>
        </div> -->
        <br>
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
            <h3>Jadwal Kuliah Semester <?= $semester_sekarang ?></h3>

            <table class="table table-bordered mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>Mata Kuliah</th>
                        <th>Hari</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Ruang</th>
                        <th>SKS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $jadwal->fetch_assoc()): ?>
                    <tr>
                        
                        <td><?= $row['nama_kelas'] ?></td>
                        <td><?= $row['hari'] ?></td>
                        <td><?= $row['jam_mulai'] ?></td>
                        <td><?= $row['jam_selesai'] ?></td>
                        <td><?= $row['ruangan'] ?></td>
                        <td><?= $row['sks'] ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

        </div>
    </div>


    <!-- Sidebar -->
    <!-- <div class="offcanvas offcanvas-start text-bg-dark" data-bs-backdrop="false" id="sidebar">
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
                <li><a href="#" class="nav-link active"><i class="bi bi-columns-gap"></i></i> Dashboard</a></li>
            </ul>
            <br>
            <ul class="nav nav-pills flex-column mb-auto">
                <h6>Perkuliahan</h6>
                <li><a href="jadwalKuliah.php?nim=<?=$nim?>" class="nav-link nav-link:hover"><i class="bi bi-calendar-event"></i> Jadwal Kuliah</a></li>
                <li><a href="#" class="nav-link nav-link:hover"><i class="bi bi-book"></i> Jadwal Ujian</a></li>
                <li><a href="#" class="nav-link nav-link:hover"><i class="bi bi-journal-text"></i> Hasil Studi</a></li>
                <li><a href="#" class="nav-link nav-link:hover"><i class="bi bi-journal-check"></i> Transkrip Nilai</a></li>
            </ul>
            <br>
            <ul class="nav nav-pills flex-column mb-auto">
                <h6>Dosen</h6>
                <li><a href="daftar" class="nav-link nav-link:hover"><i class="bi bi-list"></i> Daftar dosen</a></li>
                <li><a href="#" class="nav-link nav-link:hover"><i class="bi bi-calendar-event"></i> Jadwal Dosen</a></li>
            </ul>
            <br>
            <ul class="nav nav-pills flex-column mb-auto">
                <h6></h6>
                <li><a href="logout.php" class="nav-link nav-link:hover"><i class="bi bi-door-open"></i> Logout</a></li>
            </ul>
        </div>
    </div> -->
    <?php include 'process/sidebar.php'; ?>
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