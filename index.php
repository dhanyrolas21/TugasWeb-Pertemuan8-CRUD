<?php
require 'koneksi.php';
require 'flash.php';

$pdo = Database::getInstance();

$keyword = trim($_GET['q'] ?? '');

$sql = "SELECT p.*, k.nama_kategori, s.nama_supplier
        FROM produk p
        JOIN kategori k ON p.kategori_id = k.id
        JOIN supplier s ON p.supplier_id = s.id";

if ($keyword !== '') {
    $sql .= " WHERE p.nama_produk LIKE :keyword";
}

$sql .= " ORDER BY p.id ASC";

$stmt = $pdo->prepare($sql);

if ($keyword !== '') {
    $stmt->bindValue(':keyword', '%' . $keyword . '%');
}

$stmt->execute();
$produk = $stmt->fetchAll(PDO::FETCH_ASSOC);

$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CRUD Inventaris — Data Produk</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h2>📦 Data Produk Inventaris</h2>
  <a href="tambah.php" class="btn-add">+ Tambah Produk</a>

  <?php if ($flash): ?>
    <div class="alert alert-<?= $flash['type'] === 'success' ? 'success' : 'error' ?>">
      <?= htmlspecialchars($flash['message']) ?>
    </div>
  <?php endif; ?>

  <form method="get" action="index.php" class="search-form">
    <input type="text" name="q" placeholder="Cari nama produk..." value="<?= htmlspecialchars($keyword) ?>">
    <button type="submit">Cari</button>
    <?php if ($keyword !== ''): ?>
      <a href="index.php">Reset</a>
    <?php endif; ?>
  </form>

  <table>
    <tr>
      <th>No</th>
      <th>Nama Produk</th>
      <th>Kategori</th>
      <th>Supplier</th>
      <th>Harga</th>
      <th>Stok</th>
      <th>Opsi</th>
    </tr>
    <?php if (empty($produk)): ?>
      <tr><td colspan="7">Tidak ada data produk.</td></tr>
    <?php else: ?>
      <?php $no = 1; foreach ($produk as $row): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($row['nama_produk']) ?></td>
        <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
        <td><?= htmlspecialchars($row['nama_supplier']) ?></td>
        <td>Rp <?= number_format((float) $row['harga'], 0, ',', '.') ?></td>
        <td><?= (int) $row['stok'] ?></td>
        <td>
          <a href="edit.php?id=<?= (int) $row['id'] ?>">Edit</a>
          <a href="hapus.php?id=<?= (int) $row['id'] ?>" onclick="return confirm('Yakin hapus produk ini?')">Hapus</a>
        </td>
      </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </table>
</div>
</body>
</html>
