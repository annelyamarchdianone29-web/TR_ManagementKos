<?php
require_once __DIR__ . '/../../Conection/get_kamar.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kamar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">

                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h2 class="h4 mb-0">Edit Kamar</h2>
                    </div>

                    <div class="card-body">
                        <form action="../../Connection/post_kamar.php" method="POST">
                            <input type="hidden" name="id" value="<?= $row['id']; ?>">

                            <div class="mb-3">
                                <label class="form-label">Nomor Kamar</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="nomor_kamar"
                                    value="<?= htmlspecialchars($row['nomor_kamar']); ?>"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Harga Kamar</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    name="harga"
                                    min="0"
                                    value="<?= htmlspecialchars($row['harga']); ?>"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status Kamar</label>
                                <select class="form-select" name="status" required>
                                    <option value="0"
                                        <?= $row['status_kamar'] == 0 ? 'selected' : ''; ?>>
                                        Ready
                                    </option>
                                    <option value="1"
                                        <?= $row['status_kamar'] == 1 ? 'selected' : ''; ?>>
                                        Not Ready
                                    </option>
                                </select>
                            </div>

                            <input
                                type="hidden"
                                name="is_active"
                                value="<?= $row['is_active']; ?>">

                            <div class="d-flex gap-2">
                                <button type="submit" name="simpan" class="btn btn-primary">
                                    Simpan Perubahan
                                </button>
                                <a href="index.php" class="btn btn-outline-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>