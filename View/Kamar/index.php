<?php
require_once __DIR__ . '/../../Conection/koneksi.php';

$sql_read = "SELECT * FROM m_kamar";
$result = mysqli_query($conn, $sql_read);

if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Kamar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-4 mb-5">

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white py-3">
                <h3 class="mb-0">Management Kamar</h3>
            </div>

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                    <h4 class="mb-0">Daftar Kamar</h4>

                    <a href="create.php" class="btn btn-primary">
                        + Tambah Kamar
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle mb-0">

                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nomor Kamar</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>Is Active</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?= $row['id']; ?></td>

                                    <td>
                                        <?= htmlspecialchars($row['nomor_kamar']); ?>
                                    </td>

                                    <td>
                                        Rp <?= number_format($row['harga'], 0, ',', '.'); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['status_kamar']); ?>
                                    </td>

                                    <td>
                                        <?= $row['is_active']; ?>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">

                                            <a href="edit.php?id=<?= $row['id']; ?>"
                                                class="btn btn-warning btn-sm">
                                                Edit
                                            </a>

                                            <a href="hapus.php?id=<?= $row['id']; ?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="konfirmasiHapus(event, this.href, '<?= htmlspecialchars($row['nomor_kamar'], ENT_QUOTES); ?>')">
                                                Hapus
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function konfirmasiHapus(e, url, nomor) {
        e.preventDefault();
        Swal.fire({
            title: 'Nonaktifkan kamar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Ya, nonaktifkan',
            cancelButtonText: 'Batal'
        }).then(r => { if (r.isConfirmed) location.href = url; });
    }
    </script>
</body>

</html>