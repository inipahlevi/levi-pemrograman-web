<?php
session_start(); // Memulai session

// Inisialisasi array barang di session jika belum ada
if (!isset($_SESSION['barang'])) {
    $_SESSION['barang'] = [
        ["id" => 1, "nama" => "Buku", "kategori" => "Alat Tulis", "harga" => 20000],
        ["id" => 2, "nama" => "Pulpen", "kategori" => "Alat Tulis", "harga" => 5000]
    ];
}

// Tambah Barang
if (isset($_POST['tambah'])) {
    $idBaru = count($_SESSION['barang']) + 1;
    $_SESSION['barang'][] = [
        "id" => $idBaru,
        "nama" => $_POST['nama'],
        "kategori" => $_POST['kategori'],
        "harga" => $_POST['harga']
    ];
}

// Hapus Barang
if (isset($_GET['hapus'])) {
    $_SESSION['barang'] = array_filter($_SESSION['barang'], fn($b) => $b['id'] != $_GET['hapus']);
    $_SESSION['barang'] = array_values($_SESSION['barang']); // Reset indeks array
}

// Ambil data barang untuk di-edit
$barangEdit = null;
if (isset($_GET['edit'])) {
    foreach ($_SESSION['barang'] as $b) {
        if ($b['id'] == $_GET['edit']) {
            $barangEdit = $b;
            break;
        }
    }
}

// Simpan perubahan setelah edit
if (isset($_POST['update'])) {
    foreach ($_SESSION['barang'] as &$b) {
        if ($b['id'] == $_POST['id']) {
            $b['nama'] = $_POST['nama'];
            $b['kategori'] = $_POST['kategori'];
            $b['harga'] = $_POST['harga'];
            break;
        }
    }
    header("Location: praktikum4.php"); // Redirect untuk menghindari resubmission
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Barang</title>
    <style>
        .form-group { margin-bottom: 10px; }
        table { width: 50%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
    </style>
</head>
<body>
    <h2><?= $barangEdit ? "Edit Barang" : "Tambah Barang" ?></h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $barangEdit['id'] ?? '' ?>">
        <div class="form-group">
            <label>Nama Barang:</label>
            <input type="text" name="nama" value="<?= $barangEdit['nama'] ?? '' ?>" required>
        </div>
        <div class="form-group">
            <label>Kategori Barang:</label>
            <input type="text" name="kategori" value="<?= $barangEdit['kategori'] ?? '' ?>" required>
        </div>
        <div class="form-group">
            <label>Harga Barang:</label>
            <input type="number" name="harga" value="<?= $barangEdit['harga'] ?? '' ?>" required>
        </div>
        <button type="submit" name="<?= $barangEdit ? 'update' : 'tambah' ?>">
            <?= $barangEdit ? 'Update Barang' : 'Tambah Barang' ?>
        </button>
    </form>

    <h2>Daftar Barang</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($_SESSION['barang'] as $b) { ?>
        <tr>
            <td><?= $b['id'] ?></td>
            <td><?= $b['nama'] ?></td>
            <td><?= $b['kategori'] ?></td>
            <td><?= $b['harga'] ?></td>
            <td>
                <a href="?edit=<?= $b['id'] ?>">Edit</a> | 
                <a href="?hapus=<?= $b['id'] ?>" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>