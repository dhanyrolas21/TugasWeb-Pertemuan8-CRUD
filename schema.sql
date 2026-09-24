-- Jalankan lewat tab "SQL" di phpMyAdmin, atau lewat terminal:
--   mysql -u root -p < schema.sql

CREATE DATABASE IF NOT EXISTS inventaris_db;
USE inventaris_db;

CREATE TABLE kategori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL
);

CREATE TABLE supplier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_supplier VARCHAR(100) NOT NULL,
    kontak VARCHAR(50),
    alamat VARCHAR(255)
);

CREATE TABLE produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_produk VARCHAR(150) NOT NULL,
    kategori_id INT NOT NULL,
    supplier_id INT NOT NULL,
    harga DECIMAL(12,2) NOT NULL DEFAULT 0,
    stok INT NOT NULL DEFAULT 0,
    FOREIGN KEY (kategori_id) REFERENCES kategori(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (supplier_id) REFERENCES supplier(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- Bonus: log aktivitas — diisi otomatis lewat transaction tiap kali produk dihapus
CREATE TABLE log_aktivitas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aksi VARCHAR(50) NOT NULL,
    deskripsi VARCHAR(255) NOT NULL,
    waktu DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Seed data kategori (5)
INSERT INTO kategori (nama_kategori) VALUES
('Elektronik'),
('Alat Tulis Kantor'),
('Furnitur'),
('Bahan Baku'),
('Peralatan Kebersihan');

-- Seed data supplier (5)
INSERT INTO supplier (nama_supplier, kontak, alamat) VALUES
('CV Sumber Rejeki', '0812-1000-1001', 'Jl. Gatot Subroto No. 10, Medan'),
('PT Mitra Elektronik', '0813-2000-2002', 'Jl. Ahmad Yani No. 25, Medan'),
('Toko ATK Jaya', '0811-3000-3003', 'Jl. Sisingamangaraja No. 5, Medan'),
('UD Berkah Furnitur', '0852-4000-4004', 'Jl. Setia Budi No. 88, Medan'),
('CV Bersih Selalu', '0821-5000-5005', 'Jl. Pancing No. 12, Medan');

-- Seed data produk (6, > minimal 5)
INSERT INTO produk (nama_produk, kategori_id, supplier_id, harga, stok) VALUES
('Laptop ASUS Vivobook', 1, 2, 7500000, 12),
('Pulpen Standard AE7', 2, 3, 3000, 200),
('Kursi Kantor Ergonomis', 3, 4, 850000, 15),
('Kertas HVS A4 1 Rim', 2, 3, 45000, 80),
('Sabun Pembersih Lantai 1L', 5, 5, 18000, 60),
('Mouse Wireless Logitech', 1, 2, 150000, 40);
