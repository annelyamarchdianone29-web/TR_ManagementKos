<?php
require_once __DIR__ . '/../../Conection/koneksi.php';

$pesan = '';

if (isset($_POST['simpan'])) {
    $no_hp = trim($_POST['no_hp']);
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);

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
                             (no_hp, nama, email)
                             VALUES (?, ?, ?)";

            $stmt_penghuni = mysqli_prepare($conn, $sql_penghuni);

            mysqli_stmt_bind_param(
                $stmt_penghuni,
                "sss",
                $no_hp,
                $nama,
                $email
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

    <!-- Bootstrap 5 CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <div class="card shadow-sm border-0">

                    <!-- Header -->
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0">Tambah Penghuni</h4>
                    </div>

                    <!-- Form -->
                    <div class="card-body p-4">

                        <p class="text-muted mb-4">
                            Silakan isi formulir berikut untuk menambahkan data penghuni.
                        </p>

                        <!-- Pesan Error -->
                        <?php if ($pesan != '') { ?>
                            <div class="alert alert-danger" role="alert">
                                <?= htmlspecialchars($pesan); ?>
                            </div>
                        <?php } ?>

                        <form action="" method="POST">

                            <!-- Nomor HP -->
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">
                                    Nomor HP
                                </label>

                                <input
                                    type="tel"
                                    class="form-control"
                                    id="no_hp"
                                    name="no_hp"
                                    placeholder="Masukkan nomor HP"
                                    value="<?= htmlspecialchars($_POST['no_hp'] ?? ''); ?>"
                                    required>
                            </div>

                            <!-- Nama Lengkap -->
                            <div class="mb-3">
                                <label for="nama" class="form-label">
                                    Nama Lengkap
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="nama"
                                    name="nama"
                                    placeholder="Masukkan nama lengkap"
                                    value="<?= htmlspecialchars($_POST['nama'] ?? ''); ?>"
                                    required>
                            </div>

                            <!-- Keterangan -->
                            <div class="mb-4">
                                <label for="email" class="form-label">
                                    Keterangan
                                </label>

                                <textarea
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    rows="3"
                                    placeholder="Masukkan keterangan"
                                    required><?= htmlspecialchars($_POST['email'] ?? ''); ?></textarea>
                            </div>

                            <!-- Tombol -->
                            <div class="d-flex justify-content-between gap-2">

                                <a
                                    href="index.php"
                                    class="btn btn-outline-secondary">
                                    Batal
                                </a>

                                <button
                                    type="submit"
                                    name="simpan"
                                    class="btn btn-primary">
                                    Simpan Penghuni
                                </button>

                            </div>

                        </form>
                    </div>
                </div>

                <!-- Footer -->
                <p class="text-center text-muted mt-3 small">
                    Sistem Manajemen Penghuni
                </p>

            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
