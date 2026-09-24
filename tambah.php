<?php
require 'koneksi.php';
$pdo = Database::getInstance();

$kategori = $pdo->query("SELECT * FROM kategori ORDER BY nama_kategori ASC")->fetchAll(PDO::FETCH_ASSOC);
$supplier = $pdo->query("SELECT * FROM supplier ORDER BY nama_supplier ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tambah Produk</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h2>➕ Tambah Produk</h2>
  <a href="index.php">← Kembali</a>

  <form method="post" action="tambah_aksi.php">
    <div class="form-group">
      <label>Nama Produk</label>
      <input type="text" name="nama_produk" required>
    </div>

    <div class="form-group">
      <label>Kategori</label>
      <select name="kategori_id" required>
        <option value="">-- Pilih Kategori --</option>
        <?php foreach ($kategori as $k): ?>
          <option value="<?= (int) $k['id'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label>Supplier</label>
      <select name="supplier_id" required>
        <option value="">-- Pilih Supplier --</option>
        <?php foreach ($supplier as $s): ?>
          <option value="<?= (int) $s['id'] ?>"><?= htmlspecialchars($s['nama_supplier']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label>Harga</label>
      <input type="number" name="harga" min="0" step="0.01" required>
    </div>

    <div class="form-group">
      <label>Stok</label>
      <input type="number" name="stok" min="0" required>
    </div>

    <button type="submit">Simpan</button>
  </form>
</div>
</body>
</html>
