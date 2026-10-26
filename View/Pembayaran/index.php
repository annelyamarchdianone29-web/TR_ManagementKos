<?php include __DIR__ . '/../menu.php'; ?>
<?php
require_once __DIR__ . '/../../Conection/koneksi.php';

$sql = "SELECT
            b.id,
            b.kode_transaksi,
            b.status,
            b.nominal_pembayaran,
            h.nama,
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
    <title>Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <h2>Daftar Pembayaran</h2>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Kode Transaksi</th>
                <th>Penghuni</th>
                <th>Kamar</th>
                <th>Harga Kamar</th>
                <th>Status</th>
                <th>Nominal Dibayar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['kode_transaksi']); ?></td>
                    <td><?= htmlspecialchars($row['nama']); ?></td>
                    <td><?= htmlspecialchars($row['nomor_kamar']); ?></td>
                    <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td><?= $row['status'] == 1 ? 'Paid' : 'Unpaid'; ?></td>
                    <td>
                        <?= $row['nominal_pembayaran'] !== null
                            ? 'Rp ' . number_format($row['nominal_pembayaran'], 0, ',', '.')
                            : '-'; ?>
                    </td>
                    <td>
                        <?php if ($row['status'] == 0) { ?>
                            <form action="proses_bayar.php" method="POST"
                                onsubmit="return confirm('Konfirmasi pembayaran ini?');">
                                <input type="hidden" name="id_pembayaran" value="<?= $row['id']; ?>">
                                <button type="submit">Konfirmasi Bayar</button>
                            </form>
                        <?php } else { ?>
                            -
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>