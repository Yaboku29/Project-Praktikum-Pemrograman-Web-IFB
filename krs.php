<?php

session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}
if (!isset($_SESSION['krs_initialized'])) {
    $_SESSION['krs_temp'] = [];
    $_SESSION['krs_initialized'] = true;
}
require "config/db.php";
$nim = $_SESSION['username'];
$status = $_SESSION['role'];
$nama = $_SESSION['name'];
$iduser=$_SESSION['id'];

$semesterAktif = 5; // nanti bisa kamu ganti otomatis


// -----------------------------------------------
// 2. Ambil kelas yang tersedia
// -----------------------------------------------
$q = $db->query("SELECT * FROM kelas ORDER BY nama_kelas ASC");


// -----------------------------------------------
// 3. Inisialisasi session keranjang krs
// -----------------------------------------------
if (!isset($_SESSION['krs_temp'])) {
    $_SESSION['krs_temp'] = [];
}


// -----------------------------------------------
// 4. Menambah kelas ke KRS sementara
// -----------------------------------------------
if (isset($_POST['ambil'])) {

    $id_kelas = $_POST['kelas_id'];

    // Cek apakah sudah dipilih
    if (in_array($id_kelas, $_SESSION['krs_temp'])) {
        $error = "Kelas ini sudah kamu ambil.";
    } else {
        // cek sks total
        $sksTotal = 0;

        foreach ($_SESSION['krs_temp'] as $kid) {
            $r = $db->query("SELECT sks FROM kelas WHERE id = $kid")->fetch_assoc();
            $sksTotal += $r['sks'];
        }

        // SKS kelas yang baru dipilih
        $r2 = $db->query("SELECT sks, tempatDuduk, isi FROM kelas WHERE id = $id_kelas")->fetch_assoc();

        if ($r2['isi'] >= $r2['tempatDuduk']) {
            $error = "Kelas penuh!";
        } 
        else if ($sksTotal + $r2['sks'] > 24) {
            $error = "Total SKS melebihi batas 24.";
        } 
        else {
            $_SESSION['krs_temp'][] = $id_kelas;
            $success = "Kelas berhasil ditambahkan.";
        }
    }
}


// -----------------------------------------------
// 5. Submit KRS ke database
// -----------------------------------------------
if (isset($_POST['submit_krs'])) {

    if (empty($_SESSION['krs_temp'])) {
        $error = "Tidak ada kelas yang dipilih!";
    } else {

        // Insert KRS utama
        $qKRS = $db->prepare("SELECT idKRS FROM krs WHERE idUser = ? AND semester = ?");
        $qKRS->bind_param("ii", $iduser, $semesterAktif);
        $qKRS->execute();
        $res = $qKRS->get_result();

        if ($res->num_rows === 0) {
            $error = "KRS belum dibuat untuk semester ini!";
        } else{
            $row = $res->fetch_assoc();
            $id_krs = $row['idKRS'];

            // Insert detail
            foreach ($_SESSION['krs_temp'] as $kid) {
                $db->query("INSERT INTO krs_details (id_krs, id_kelas) VALUES ($id_krs, $kid)");
    
                // update jumlah mahasiswa
                $db->query("UPDATE kelas SET isi = isi + 1 WHERE id = $kid");
                
            }
    
            // bersihkan temp
            $_SESSION['krs_temp'] = [];
    
            $success = "KRS berhasil disubmit.";

        }

    }
}
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
        <div class="p-4 bg-light text-center py-4 border-bottom border-top">
            <h3 class="fw-bold"><?= $nama ?> <span class="text-muted">(<?= $nim ?>)</span></h3>
            <div class="text-muted">
                Fakultas Teknik Industri | Teknik Informatika | Informatika
            </div>
            <div class="mt-2">
                <small><i class="bi bi-person"></i>
                    <a href="" style="color: inherit; text-decoration: none;">Simon Pulung Nugroho, S.Kom., M.Cs.</a> </small>
            </div>
        </div>
        <br>
        <div class="container">
                <!-- Notifikasi -->
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <?php if(isset($success)): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php endif; ?>

                <h3 class="fw-bold mb-3">Pengambilan KRS Semester <?= $semesterAktif ?></h3>

                <!-- Tabel kelas yang tersedia -->
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="m-0">Daftar Kelas</h5>
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nama Kelas</th>
                                    <th>SKS</th>
                                    <th>Hari</th>
                                    <th>Waktu</th>
                                    <th>Ruangan</th>
                                    <th>Kapasitas</th>
                                    <th>Ambil</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $q->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $row['nama_kelas'] ?></td>
                                    <td><?= $row['sks'] ?></td>
                                    <td><?= $row['hari'] ?></td>
                                    <td><?= $row['jam_mulai'] ?> - <?= $row['jam_selesai'] ?></td>
                                    <td><?= $row['ruangan'] ?></td>
                                    <td><?= $row['isi'] ?>/<?= $row['tempatDuduk'] ?></td>
                                    <td>
                                        <form method="POST">
                                            <input type="hidden" name="kelas_id" value="<?= $row['id'] ?>">
                                            <button class="btn btn-primary btn-sm" name="ambil">
                                                <i class="bi bi-plus-circle"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tabel KRS Sementara -->
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="m-0">KRS Sementara</h5>
                    </div>

                    <div class="card-body table-responsive">
                        <?php if(empty($_SESSION['krs_temp'])): ?>
                            <div class="alert alert-warning">Belum ada kelas yang diambil.</div>
                        <?php else: ?>
                        <table class="table table-bordered">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Nama Kelas</th>
                                    <th>SKS</th>
                                    <th>Hari</th>
                                    <th>Waktu</th>
                                    <th>Ruangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $totalSKS = 0;
                                foreach($_SESSION['krs_temp'] as $kid):
                                    $rs = $db->query("SELECT * FROM kelas WHERE id = $kid")->fetch_assoc();
                                    $totalSKS += $rs['sks'];
                                ?>
                                <tr>
                                    <td><?= $rs['nama_kelas'] ?></td>
                                    <td><?= $rs['sks'] ?></td>
                                    <td><?= $rs['hari'] ?></td>
                                    <td><?= $rs['jam_mulai'] ?> - <?= $rs['jam_selesai'] ?></td>
                                    <td><?= $rs['ruangan'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <div class="text-end fw-bold">
                            Total SKS: <?= $totalSKS ?> / 24
                        </div>

                        <form method="POST" class="mt-3">
                            <button class="btn btn-success" name="submit_krs">
                                Submit KRS
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
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