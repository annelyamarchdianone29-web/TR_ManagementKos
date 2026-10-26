<?php include __DIR__ . '/../menu.php'; ?>
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

<body>
    <h2>Management Kamar</h2>
    <a href="create.php">Tambah Kamar</a>
    <hr>
    <h2>Daftar Kamar</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Nomor Kamar</th>
            <th>Harga</th>
            <th>Status</th>
            <th>Is Active</th>
            <th>Aksi</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= htmlspecialchars($row['nomor_kamar']); ?></td>
                <td><?= $row['harga']; ?></td>
                <td><?= htmlspecialchars($row['status_kamar']); ?></td>
                <td><?= $row['is_active']; ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id']; ?>">Edit</a>
                    <a href="hapus.php?id=<?= $row['id']; ?>"
                        onclick="return confirm('Yakin ingin menonaktifkan kamar ini?')">
                        Hapus
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>