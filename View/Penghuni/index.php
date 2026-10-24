<?php
require_once __DIR__ . '/../../Conection/koneksi.php';

$sql_read = "SELECT * FROM m_penghuni";
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
    <title>Management Penghuni</title>
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
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= htmlspecialchars($row['no_hp']); ?></td>
                <td><?= $row['nama_lengkap']; ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>