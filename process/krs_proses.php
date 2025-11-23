<?php

$sql = "SELECT 
            krs.semester,
            kelas.nama_kelas,
            kelas.sks,
            MAX(CASE WHEN p.jenis='kuis' THEN p.nilai END) kuis,
            MAX(CASE WHEN p.jenis='tugas' THEN p.nilai END) tugas,
            MAX(CASE WHEN p.jenis='uts' THEN p.nilai END) uts,
            MAX(CASE WHEN p.jenis='uas' THEN p.nilai END) uas
        FROM krs
        JOIN krs_detail kd ON krs.idKRS = kd.id_krs
        JOIN kelas ON kelas.id = kd.id_kelas
        LEFT JOIN penilaian p ON p.id_krs_detail = kd.id_krs_detail
        WHERE krs.idUser = ?
        GROUP BY krs.semester, kelas.nama_kelas, kelas.sks";

$stmt = $db->prepare($sql);
$stmt->bind_param("i", $idUSer);
$stmt->execute();
$result = $stmt->get_result();