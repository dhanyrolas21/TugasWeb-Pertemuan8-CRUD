<?php
require 'koneksi.php';
require 'flash.php';

$pdo = Database::getInstance();

$id = (int) ($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT nama_produk FROM produk WHERE id = :id");
$stmt->execute([':id' => $id]);
$produk = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produk) {
    set_flash('error', 'Produk tidak ditemukan.');
    header('Location: index.php');
    exit;
}

try {
    $pdo->beginTransaction();

    $deleteStmt = $pdo->prepare("DELETE FROM produk WHERE id = :id");
    $deleteStmt->execute([':id' => $id]);

    // Bonus: catat aktivitas hapus dalam transaction yang sama —
    // kalau salah satu gagal, keduanya dibatalkan (rollback), tidak setengah-setengah.
    $logStmt = $pdo->prepare(
        "INSERT INTO log_aktivitas (aksi, deskripsi) VALUES ('DELETE', :deskripsi)"
    );
    $logStmt->execute([
        ':deskripsi' => 'Menghapus produk: ' . $produk['nama_produk'] . ' (ID ' . $id . ')',
    ]);

    $pdo->commit();
    set_flash('success', 'Produk "' . $produk['nama_produk'] . '" berhasil dihapus.');
} catch (PDOException $e) {
    $pdo->rollBack();
    set_flash('error', 'Gagal menghapus produk: ' . $e->getMessage());
}

header('Location: index.php');
exit;
