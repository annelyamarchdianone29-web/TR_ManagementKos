<?php
require_once __DIR__ . '/../../Conection/koneksi.php';

if (isset($_GET['id'])) {
    $id_target = (int) $_GET['id'];

    $sql_update = "UPDATE m_kamar
                   SET is_active = 1
                   WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql_update);
    mysqli_stmt_bind_param($stmt, "i", $id_target);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit;
    } else {
        die("Gagal menonaktifkan kamar.");
    }
} else {
    die("ID kamar tidak ditemukan.");
}
