<?php
// Memasukkan koneksi ke database
include "include/koneksi.php";

// Hash password
$hashed_password_admin = password_hash('123', PASSWORD_DEFAULT);
$hashed_password_kasir = password_hash('123', PASSWORD_DEFAULT);

// Menyusun query untuk insert data
$query = "INSERT INTO tb_users (username, userpass, nama, jk, alamat, usertelp, userfoto, level) 
VALUES 
('admin', '$hashed_password_admin', 'Admin', 'perempuan', 'Malang', '08123456789', '', 'admin'),
('kasir', '$hashed_password_kasir', 'Kasir', 'laki-laki', 'Malang', '08987654321', '', 'kasir')";

// Menjalankan query untuk memasukkan data
if (mysqli_query($conn, $query)) {
    echo "Data user berhasil ditambahkan dengan password yang di-hash!";
} else {
    echo "Error: " . mysqli_error($conn);
}

// Menutup koneksi
mysqli_close($conn);
?>
