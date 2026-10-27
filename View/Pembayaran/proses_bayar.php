<?php
require_once __DIR__ . '/../../Conection/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Akses tidak valid.");
}

$id_pembayaran = (int) ($_POST['id_pembayaran'] ?? 0);
if ($id_pembayaran === 0) {
    die("ID pembayaran tidak valid.");
}

mysqli_begin_transaction($conn);

try {
    // ambil tagihan yang masih unpaid + harga kamarnya
    $stmt = mysqli_prepare($conn, "SELECT k.harga
                                   FROM t_pembayaran b
                                   JOIN t_assign_penghuni a ON a.id = b.id_t_assign_penghuni
                                   JOIN m_kamar k ON k.id = a.id_kamar
                                   WHERE b.id = ? AND b.status = 0
                                   FOR UPDATE");
    mysqli_stmt_bind_param($stmt, "i", $id_pembayaran);
    mysqli_stmt_execute($stmt);
    $data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if (!$data) {
        throw new Exception("Tagihan tidak ditemukan atau sudah dibayar.");
    }

    // set paid + isi nominal dengan harga kamar
    $stmt = mysqli_prepare($conn, "UPDATE t_pembayaran
                                   SET status = 1, nominal_pembayaran = ?
                                   WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $data['harga'], $id_pembayaran);
    mysqli_stmt_execute($stmt);

    mysqli_commit($conn);
    header("Location: index.php");
    exit;
} catch (Exception $e) {
    mysqli_rollback($conn);
    die("Gagal: " . htmlspecialchars($e->getMessage()));
}
