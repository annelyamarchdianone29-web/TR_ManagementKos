<?php
require_once __DIR__ . '/../../Conection/koneksi.php';

$pesan_error = "";

if (isset($_POST['simpan'])) {
    $nomor_kamar = trim($_POST['nomor_kamar']);
    $harga = $_POST['harga'];
    $status_kamar = $_POST['status'];
    $is_active = $_POST['is_active'];

    $sql_cek = "SELECT id FROM m_kamar WHERE nomor_kamar = ?";
    $stmt_cek = mysqli_prepare($conn, $sql_cek);
    mysqli_stmt_bind_param($stmt_cek, "s", $nomor_kamar);
    mysqli_stmt_execute($stmt_cek);

    $result_cek = mysqli_stmt_get_result($stmt_cek);

    if (mysqli_num_rows($result_cek) > 0) {
        $pesan_error = "Nomor kamar sudah terdaftar!";
    } else {
        $sql_insert = "INSERT INTO m_kamar
                       (nomor_kamar, harga, status_kamar, is_active)
                       VALUES (?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql_insert);

        mysqli_stmt_bind_param(
            $stmt,
            "siii",
            $nomor_kamar,
            $harga,
            $status_kamar,
            $is_active
        );

        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php");
            exit;
        } else {
            echo "Gagal menyimpan: " . mysqli_stmt_error($stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kamar</title>
</head>

<body>

    <h2>Tambah Kamar</h2>

    <?php if ($pesan_error != "") { ?>
        <p style="color: red;">
            <?= htmlspecialchars($pesan_error); ?>
        </p>
    <?php } ?>

    <form method="POST">
        <label>Nomor Kamar</label><br>
        <input
            type="text"
            name="nomor_kamar"
            value="<?= htmlspecialchars($_POST['nomor_kamar'] ?? ''); ?>"
            required>
        <br><br>

        <label>Harga</label><br>
        <input
            type="number"
            name="harga"
            min="0"
            value="<?= htmlspecialchars($_POST['harga'] ?? ''); ?>"
            required>
        <br><br>

        <label>Status Kamar</label><br>
        <select name="status" required>
            <option value="">-- Pilih Status --</option>
            <option value="0">Ready</option>
            <option value="1">Not Ready</option>
        </select>
        <br><br>

        <label>Status Aktif</label><br>
        <select name="is_active" required>
            <option value="">-- Pilih Status Aktif --</option>
            <option value="0">Aktif</option>
            <option value="1">Tidak Aktif</option>
        </select>
        <br><br>

        <button type="submit" name="simpan">Simpan</button>
        <a href="index.php">Kembali</a>
    </form>

</body>

</html>