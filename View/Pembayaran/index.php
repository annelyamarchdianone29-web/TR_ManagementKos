<?php
require_once __DIR__ . '/../../Conection/koneksi.php';

$sql = "SELECT
            b.id,
            b.kode_transaksi,
            b.status,
            b.nominal_pembayaran,
            h.nama_lengkap,
            k.nomor_kamar,
            k.harga
        FROM t_pembayaran b
        JOIN t_assign_penghuni a ON a.id = b.id_t_assign_penghuni
        JOIN m_penghuni h ON h.id = a.id_penghuni
        JOIN m_kamar k ON k.id = a.id_kamar
        ORDER BY b.id ASC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Pembayaran</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <?php include __DIR__ . '/../menu.php'; ?>

    <div class="container mt-4 mb-5">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-primary text-white py-3">
                <h3 class="mb-0">Management Pembayaran</h3>
            </div>

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                    <h4 class="mb-0">Daftar Pembayaran</h4>
                    <p class="text-secondary mb-0">
                        Kelola dan pantau status pembayaran penghuni kos.
                    </p>
                </div>

                <div class="table-responsive">

                    <table class="table table-bordered table-striped table-hover align-middle mb-0">

                        <thead class="table-dark">
                            <tr>
                                <th>Kode Transaksi</th>
                                <th>Penghuni</th>
                                <th>Kamar</th>
                                <th>Harga Kamar</th>
                                <th>Status</th>
                                <th>Nominal Dibayar</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td class="fw-semibold">
                                        <?= htmlspecialchars($row['kode_transaksi']); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['nama_lengkap']); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['nomor_kamar']); ?>
                                    </td>

                                    <td>
                                        Rp <?= number_format($row['harga'], 0, ',', '.'); ?>
                                    </td>

                                    <td>
                                        <?php if ($row['status'] == 1) { ?>
                                            <span class="badge bg-success px-3 py-2">
                                                Paid
                                            </span>
                                        <?php } else { ?>
                                            <span class="badge bg-danger px-3 py-2">
                                                Unpaid
                                            </span>
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <?= $row['nominal_pembayaran'] !== null
                                            ? 'Rp ' . number_format($row['nominal_pembayaran'], 0, ',', '.')
                                            : '-'; ?>
                                    </td>

                                    <td class="text-center">
                                        <?php if ($row['status'] == 0) { ?>
                                            <form action="proses_bayar.php" method="POST"
                                                onsubmit="return confirm('Konfirmasi pembayaran ini?');">

                                                <input type="hidden" name="id_pembayaran"
                                                    value="<?= $row['id']; ?>">

                                                <button type="submit" class="btn btn-success btn-sm px-3">
                                                    Konfirmasi Bayar
                                                </button>

                                            </form>
                                        <?php } else { ?>
                                            <span class="text-secondary">-</span>
                                        <?php } ?>
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

</body>

</html>