<?php
require_once __DIR__ . '/../../Conection/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Akses tidak valid.");
}

$id_assign     = (int) ($_POST['id_assign'] ?? 0);
$id_kamar_baru = (int) ($_POST['id_kamar'] ?? 0);

if ($id_assign === 0 || $id_kamar_baru === 0) {
    die("Data tidak lengkap.");
}

mysqli_begin_transaction($conn);

try {
    // 1. ambil kamar lama (kunci barisnya)
    $stmt = mysqli_prepare($conn, "SELECT id_kamar FROM t_assign_penghuni WHERE id = ? FOR UPDATE");
    mysqli_stmt_bind_param($stmt, "i", $id_assign);
    mysqli_stmt_execute($stmt);
    $assign = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if (!$assign) {
        throw new Exception("Data assign tidak ditemukan.");
    }
    $id_kamar_lama = $assign['id_kamar'];

    // 2. pastikan kamar baru masih kosong dan aktif (cegah dua orang rebutan kamar)
    $stmt = mysqli_prepare($conn, "SELECT id FROM m_kamar
                                   WHERE id = ? AND status_kamar = 0 AND is_active = 0
                                   FOR UPDATE");
    mysqli_stmt_bind_param($stmt, "i", $id_kamar_baru);
    mysqli_stmt_execute($stmt);
    if (!mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))) {
        throw new Exception("Kamar sudah terisi atau tidak aktif.");
    }

    // 3. kalau PINDAH: kosongkan kamar lama
    if ($id_kamar_lama !== null) {
        $stmt = mysqli_prepare($conn, "UPDATE m_kamar SET status_kamar = 0 WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id_kamar_lama);
        mysqli_stmt_execute($stmt);
    }

    // 4. set kamar baru di t_assign_penghuni
    $stmt = mysqli_prepare($conn, "UPDATE t_assign_penghuni SET id_kamar = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $id_kamar_baru, $id_assign);
    mysqli_stmt_execute($stmt);

    // 5. kamar baru jadi terisi
    $stmt = mysqli_prepare($conn, "UPDATE m_kamar SET status_kamar = 1 WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id_kamar_baru);
    mysqli_stmt_execute($stmt);

    // 6. buat tagihan unpaid (kode_transaksi diisi otomatis oleh trigger)
    $stmt = mysqli_prepare($conn, "INSERT INTO t_pembayaran (id_t_assign_penghuni, status)
                                   VALUES (?, 0)");
    mysqli_stmt_bind_param($stmt, "i", $id_assign);
    mysqli_stmt_execute($stmt);

    mysqli_commit($conn);
    header("Location: ../Penghuni/index.php");
    exit;
} catch (Exception $e) {
    mysqli_rollback($conn);
    die("Gagal: " . htmlspecialchars($e->getMessage()));
}
