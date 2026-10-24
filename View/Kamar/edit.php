<?php
require_once __DIR__ . '/../../Conection/get_kamar.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kamar</title>
</head>

<body>

    <h2>Edit Kamar</h2>

    <form action="../../Connection/post_kamar.php" method="POST">
        <input type="hidden" name="id" value="<?= $row['id']; ?>">
        <label>Nomor Kamar</label><br>
        <input
            type="text"
            name="nomor_kamar"
            value="<?= htmlspecialchars($row['nomor_kamar']); ?>"
            required>
        <br><br>
        <label>Harga Kamar</label><br>
        <input
            type="number"
            name="harga"
            min="0"
            value="<?= htmlspecialchars($row['harga']); ?>"
            required>
        <br><br>
        <label>Status Kamar</label><br>
        <select name="status" required>
            <option value="0"
                <?= $row['status_kamar'] == 0 ? 'selected' : ''; ?>>
                Ready
            </option>
            <option value="1"
                <?= $row['status_kamar'] == 1 ? 'selected' : ''; ?>>
                Not Ready
            </option>
        </select>
        <br><br>
        <input
            type="hidden"
            name="is_active"
            value="<?= $row['is_active']; ?>">

        <button type="submit" name="simpan">
            Simpan Perubahan
        </button>

        <a href="index.php">Batal</a>

    </form>

</body>

</html>