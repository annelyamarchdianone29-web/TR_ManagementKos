<?php
require_once __DIR__ . '/koneksi.php';

if (isset($_POST['id'])) {
    $id_target = (int) $_POST['id'];
    $nomor_kamar = trim($_POST['nomor_kamar']);
    $harga = $_POST['harga'];
    $status_kamar = $_POST['status'];
    $is_active = $_POST['is_active'];

    // Cek nomor kamar duplikat
    $sql_cek = "SELECT id FROM m_kamar
                WHERE nomor_kamar = ? AND id != ?";

    $stmt_cek = mysqli_prepare($conn, $sql_cek);
    mysqli_stmt_bind_param(
        $stmt_cek,
        "si",
        $nomor_kamar,
        $id_target
    );
    mysqli_stmt_execute($stmt_cek);

    $result_cek = mysqli_stmt_get_result($stmt_cek);

    if (mysqli_num_rows($result_cek) > 0) {
        echo "<script>
            alert('Nomor kamar sudah digunakan!');
            window.location.href = '../View/Kamar/edit.php?id=$id_target';
        </script>";
        exit;
    }

    $sql_update = "UPDATE m_kamar
                   SET nomor_kamar = ?, harga = ?,
                       status_kamar = ?, is_active = ?
                   WHERE id = ?";

    $stmt_update = mysqli_prepare($conn, $sql_update);
    mysqli_stmt_bind_param(
        $stmt_update,
        "siiii",
        $nomor_kamar,
        $harga,
        $status_kamar,
        $is_active,
        $id_target
    );

    if (mysqli_stmt_execute($stmt_update)) {
        header("Location: ../View/Kamar/index.php");
        exit;
    } else {
        die("Gagal memperbarui kamar: " .
            mysqli_stmt_error($stmt_update));
    }
} else {
    die("ID kamar tidak ditemukan.");
}
