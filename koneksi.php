<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_skripsicode";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Gagal Konek Database: " . mysqli_connect_error());
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>