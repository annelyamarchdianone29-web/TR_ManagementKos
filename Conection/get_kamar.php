<?php
require_once __DIR__ . '/koneksi.php';

if (isset($_GET['id'])) {
    $id_target = (int) $_GET['id'];

    $sql_read = "SELECT * FROM m_kamar WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql_read);

    mysqli_stmt_bind_param($stmt, "i", $id_target);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        die("Data kamar tidak ditemukan.");
    }
} else {
    die("ID kamar tidak ditemukan.");
}
