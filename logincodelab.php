<?php 
// statement 1 - memulai session
session_start();

// statement 2 - memanggil koneksi ke database
include "include/koneksi.php";

// statement 3 - mengecek apakah tombol login ditekan
if (isset($_POST['login'])) {
  $pesan_error = "";

  // statement 4 - mengambil input username dan password dari form, lalu membersihkannya
  $username = htmlentities(strip_tags(trim($_POST["username"])));
  $pass = htmlentities(strip_tags(trim($_POST["password"])));

  // statement 5 - validasi panjang password minimal 8 karakter
  if (strlen($pass) < 8) {
    $pesan_error .= "Password minimal 8 karakter";
  } else {
    // statement 6 - query untuk mencari username di tabel tb_users
    $login = mysqli_query($conn, "SELECT * FROM tb_users WHERE username = '$username'");

    // statement 7 - menghitung jumlah data user dengan username tersebut
    $cekUser = mysqli_num_rows($login);

    // statement 8 - jika user ditemukan
    if ($cekUser > 0) {
      // statement 9 - ambil data user dari hasil query
      $row = mysqli_fetch_assoc($login);

      // statement 10 - verifikasi password yang diinput dengan yang tersimpan (hash)
      if (password_verify($pass, $row['userpass'])) {

        // statement 11 - set data session jika login berhasil
        $_SESSION['username'] = $username;
        $_SESSION['userid'] = $row['userid'];
        $_SESSION['level'] = $row['level'];
        $_SESSION['tgllogin'] = date('Y-m-d H:i:s');
        $_SESSION['login'] = true;

        // statement 12 - tampilkan alert dan arahkan ke halaman index.php
        echo "
        <script>
          alert('Login berhasil');
          window.location.href = 'index.php';
        </script>
        ";
      } else {
        // statement 13 - jika password salah
        $pesan_error .= "Password anda salah";
      }
    } else {
      // statement 14 - jika username tidak ditemukan
      $pesan_error .= "Username / Password anda salah";
    }
  }
} else {
  // statement 15 - jika tombol login belum ditekan, inisialisasi pesan error kosong
  $pesan_error = "";
}
?>
