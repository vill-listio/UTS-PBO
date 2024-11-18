<?php
$host = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "imron_pbo_uts";

$con = mysqli_connect($host, $username, $password, $database);

// Cek apakah koneksi berhasil
if (!$con) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>