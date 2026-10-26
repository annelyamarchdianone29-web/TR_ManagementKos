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

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="card shadow">

            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Management Penghuni</h2>
            </div>

            <div class="card-body">

                <h2 class="mb-4">Daftar Penghuni</h2>

                <a href="create.php" class="btn btn-primary mb-3">
                    Tambah Penghuni
                </a>

                <div class="table-responsive">

                    <table class="table table-bordered table-striped table-hover">

                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Nomor Handpone</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                                <tr>
                                    <td><?= $row['id']; ?></td>
                                    <td><?= htmlspecialchars($row['no_hp']); ?></td>
                                    <td><?= $row['nama_lengkap']; ?></td>
                                    <td><?= htmlspecialchars($row['email']); ?></td>
                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
