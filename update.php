<?php
require 'koneksi.php';
require 'flash.php';

$pdo = Database::getInstance();

$id = (int) ($_POST['id'] ?? 0);
$nama_produk = trim($_POST['nama_produk'] ?? '');
$kategori_id = (int) ($_POST['kategori_id'] ?? 0);
$supplier_id = (int) ($_POST['supplier_id'] ?? 0);
$harga = (float) ($_POST['harga'] ?? 0);
$stok = (int) ($_POST['stok'] ?? 0);

if ($nama_produk === '' || $kategori_id <= 0 || $supplier_id <= 0) {
    set_flash('error', 'Semua field wajib diisi dengan benar.');
    header('Location: edit.php?id=' . $id);
    exit;
}

$stmt = $pdo->prepare(
    "UPDATE produk
     SET nama_produk = :nama_produk, kategori_id = :kategori_id, supplier_id = :supplier_id, harga = :harga, stok = :stok
     WHERE id = :id"
);
$stmt->execute([
    ':nama_produk' => $nama_produk,
    ':kategori_id' => $kategori_id,
    ':supplier_id' => $supplier_id,
    ':harga' => $harga,
    ':stok' => $stok,
    ':id' => $id,
]);

set_flash('success', 'Produk berhasil diperbarui.');
header('Location: index.php');
exit;
