<?php
require 'koneksi.php';
$pdo = Database::getInstance();

$id = (int) ($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM produk WHERE id = :id");
$stmt->execute([':id' => $id]);
$produk = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produk) {
    die('Produk tidak ditemukan. <a href="index.php">Kembali</a>');
}

$kategori = $pdo->query("SELECT * FROM kategori ORDER BY nama_kategori ASC")->fetchAll(PDO::FETCH_ASSOC);
$supplier = $pdo->query("SELECT * FROM supplier ORDER BY nama_supplier ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Produk</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h2>✏️ Edit Produk</h2>
  <a href="index.php">← Kembali</a>

  <form method="post" action="update.php">
    <input type="hidden" name="id" value="<?= (int) $produk['id'] ?>">

    <div class="form-group">
      <label>Nama Produk</label>
      <input type="text" name="nama_produk" value="<?= htmlspecialchars($produk['nama_produk']) ?>" required>
    </div>

    <div class="form-group">
      <label>Kategori</label>
      <select name="kategori_id" required>
        <?php foreach ($kategori as $k): ?>
          <option value="<?= (int) $k['id'] ?>" <?= $k['id'] == $produk['kategori_id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($k['nama_kategori']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label>Supplier</label>
      <select name="supplier_id" required>
        <?php foreach ($supplier as $s): ?>
          <option value="<?= (int) $s['id'] ?>" <?= $s['id'] == $produk['supplier_id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($s['nama_supplier']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label>Harga</label>
      <input type="number" name="harga" min="0" step="0.01" value="<?= htmlspecialchars($produk['harga']) ?>" required>
    </div>

    <div class="form-group">
      <label>Stok</label>
      <input type="number" name="stok" min="0" value="<?= (int) $produk['stok'] ?>" required>
    </div>

    <button type="submit">Simpan Perubahan</button>
  </form>
</div>
</body>
</html>
