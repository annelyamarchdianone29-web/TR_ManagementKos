<?php include __DIR__ . '/../menu.php'; ?>
<?php
require_once __DIR__ . '/../../Conection/koneksi.php';

$sql_read = "SELECT
                p.id,
                p.no_hp,
                p.nama_lengkap,
                p.email,
                a.id AS id_assign,
                a.id_kamar
             FROM m_penghuni p
             LEFT JOIN t_assign_penghuni a
                ON p.id = a.id_penghuni";

$result = mysqli_query($conn, $sql_read);

if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Penghuni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <h2>Management Penghuni</h2>

    <a href="create.php">Tambah Penghuni</a>

    <hr>

    <h2>Daftar Penghuni</h2>

    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Nomor Handpone</th>
            <th>Nama Lengkap</th>
            <th>Email</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <thead>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= htmlspecialchars($row['no_hp']); ?></td>
                    <td><?= $row['nama_lengkap']; ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <th>ID</th>
                    <th>Nomor Handphone</th>
                    <th>Nama</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            <?php } ?>
            </thead>

            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><?= htmlspecialchars($row['no_hp']); ?></td>
                        <td><?= htmlspecialchars($row['nama']); ?></td>
                        <td><?= htmlspecialchars($row['keterangan'] ?? ''); ?></td>
                        <td>
                            <?php if ($row['id_kamar'] === null) { ?>
                                <a href="../AssignPenghuni/index.php?id_assign=<?= $row['id_assign']; ?>">ASSIGN</a>
                            <?php } else { ?>
                                <a href="../AssignPenghuni/index.php?id_assign=<?= $row['id_assign']; ?>">PINDAH</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
    </table>
</body>

</html>