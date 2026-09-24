<?php
class Database
{
    private static ?PDO $instance = null;

    // Constructor privat — mencegah instance dibuat langsung dari luar class (pola Singleton)
    private function __construct()
    {
    }

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $host = "localhost";
            $dbname = "inventaris_db";
            $username = "app";
            $password = "app123";

            try {
                self::$instance = new PDO(
                    "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
                    $username,
                    $password
                );
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Koneksi database gagal: " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}