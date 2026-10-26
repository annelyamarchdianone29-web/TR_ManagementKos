<?php
require_once __DIR__ . '/../../Conection/koneksi.php';

$pesan = '';

if (isset($_POST['simpan'])) {
    $no_hp = trim($_POST['no_hp']);
    $nama = trim($_POST['nama']);
    $keterangan = trim($_POST['keterangan']);

    $sql_cek = "SELECT id FROM m_penghuni WHERE no_hp = ?";
    $stmt_cek = mysqli_prepare($conn, $sql_cek);

    mysqli_stmt_bind_param($stmt_cek, "s", $no_hp);
    mysqli_stmt_execute($stmt_cek);

    $result_cek = mysqli_stmt_get_result($stmt_cek);

    if (mysqli_num_rows($result_cek) > 0) {
        $pesan = "Nomor HP sudah terdaftar!";
    } else {
        mysqli_begin_transaction($conn);

        try {
            $sql_penghuni = "INSERT INTO m_penghuni
                             (no_hp, nama, keterangan)
                             VALUES (?, ?, ?)";

            $stmt_penghuni = mysqli_prepare($conn, $sql_penghuni);

            mysqli_stmt_bind_param(
                $stmt_penghuni,
                "sss",
                $no_hp,
                $nama,
                $keterangan
            );

            mysqli_stmt_execute($stmt_penghuni);

            $id_penghuni = mysqli_insert_id($conn);

            $sql_assign = "INSERT INTO t_assign_penghuni
                           (id_penghuni, id_kamar)
                           VALUES (?, NULL)";

            $stmt_assign = mysqli_prepare($conn, $sql_assign);

            mysqli_stmt_bind_param(
                $stmt_assign,
                "i",
                $id_penghuni
            );

            mysqli_stmt_execute($stmt_assign);

            mysqli_commit($conn);

            header("Location: index.php");
            exit;
        } catch (mysqli_sql_exception $e) {
            mysqli_rollback($conn);
            $pesan = "Gagal menyimpan data penghuni. Periksa kembali struktur tabel.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Penghuni</title>
</head>

<body>
    <h2>Tambah Penghuni</h2>

    <?php if ($pesan != '') { ?>
        <p style="color: red;">
            <?= htmlspecialchars($pesan); ?>
        </p>
    <?php } ?>

    <form action="" method="POST">
        <label>Nomor HP</label><br>
        <input
            type="tel"
            name="no_hp"
            value="<?= htmlspecialchars($_POST['no_hp'] ?? ''); ?>"
            required>
        <br><br>

        <label>Nama Lengkap</label><br>
        <input
            type="text"
            name="nama"
            value="<?= htmlspecialchars($_POST['nama'] ?? ''); ?>"
            required>
        <br><br>

        <label>Keterangan</label><br>
        <textarea
            name="keterangan"
            required><?= htmlspecialchars($_POST['keterangan'] ?? ''); ?></textarea>
        <br><br>

        <button type="submit" name="simpan">Simpan</button>
        <a href="index.php">Batal</a>
    </form>
</body>

</html>