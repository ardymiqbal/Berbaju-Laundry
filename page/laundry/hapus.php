<?php 

// include koneksi
include "../../include/koneksi.php"; // sesuaikan path dengan struktur foldermu

$id = $_GET['id'];

// menghapus data transaksi laundry
$result = mysqli_query($conn, "DELETE FROM tb_laundry WHERE id_laundry = '$id'");

if ($result) {
  echo "
  <script>
    alert('Data Transaksi berhasil dihapus');
    window.location.href = '?page=laundry';
  </script>
  ";
} else {
  echo "
  <script>
    alert('Gagal menghapus data: ".mysqli_error($conn)."');
    window.location.href = '?page=laundry';
  </script>
  ";
}

?>
