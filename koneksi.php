<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = mysqli_connect("localhost", "root", "", "cashflow");
if (!$conn) {
    die("Koneksi Gagal: ". mysqli_connect_error());
}
?>