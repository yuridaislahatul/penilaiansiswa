<?php
$koneksi = mysqli_connect("localhost", "root", "", "nilai");

// Cek koneksi
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
}
?>