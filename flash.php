<?php
// Flash message sederhana lewat session — di-set sebelum redirect,
// diambil & langsung dihapus di halaman tujuan (jadi cuma tampil sekali).
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function set_flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function get_flash(): ?array
{
    if (!isset($_SESSION['flash'])) {
        return null;
    }

    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}
