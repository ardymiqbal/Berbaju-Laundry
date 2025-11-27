<?php
// jika tombol tambah ditekan
if (isset($_POST['tambah'])) {
  $idlaundry       = $_POST['id_laundry'];
  $pelangganid     = htmlentities(strip_tags(trim($_POST["pelangganid"])));
  $userid          = htmlentities(strip_tags(trim($_POST["userid"])));
  $jenis           = htmlentities(strip_tags(trim($_POST["id_jenis"])));
  $tarif           = htmlentities(strip_tags(trim($_POST["tarif"])));
  $tgl_selesai     = htmlentities(strip_tags(trim($_POST["tgl_selesai"])));
  $jml_kilo        = htmlentities(strip_tags(trim($_POST["jml_kilo"])));
  $totalbayar      = htmlentities(strip_tags(trim($_POST["totalbayar"])));
  $catatan         = htmlentities(strip_tags(trim($_POST["catatan"])));
  $status          = htmlentities(strip_tags(trim($_POST["status"])));
  $status_pengambilan = 0;

  // tanggal diterima otomatis
  $tgl_terima = date('Y-m-d');

  // variabel laporan
  $ket_laporan = 1;

  $pesan_error = "";

  // query insert tb_laundry
  $query = "INSERT INTO `tb_laundry`
            (`id_laundry`, `pelangganid`, `userid`, `kd_jenis`, `tgl_terima`,
            `tgl_selesai`, `jml_kilo`, `catatan`, `totalbayar`,
            `status_pembayaran`, `status_pengambilan`)
            VALUES
            ('$idlaundry', '$pelangganid', '$userid', '$jenis', '$tgl_terima',
            '$tgl_selesai', '$jml_kilo', '$catatan', '$totalbayar',
            '$status', '$status_pengambilan')";
  
  $result = mysqli_query($conn, $query);

  // Jika status = LUNAS maka masukkan ke tb_laporan
  if ($status == 1) {
      mysqli_query($conn,
          "INSERT INTO `tb_laporan`
          (`tgl_laporan`, `ket_laporan`, `catatan`, `id_laundry`, `pemasukan`)
          VALUES
          ('$tgl_terima', '$ket_laporan', '$catatan', '$idlaundry', '$totalbayar')"
      );
  }

  if ($result) {
    echo "
      <script>
        alert('Transaksi $idlaundry berhasil ditambahkan');
        window.location.href = '?page=laundry';
      </script>
    ";
  } else {
    $pesan_error .= 'Data gagal disimpan!';
  }

} else {
  $pesan_error = "";
  $pelangganid = "";
  $jenis = "";
  $tarif = "";
  $tgl_selesai = "";
  $jml_kilo = "";
  $totalbayar = "";
  $catatan = "";
  $status = "";
}

?>

<div class="page-content-wrapper">
<div class="container-fluid">

  <div class="row">
      <div class="col-sm-12">
          <div class="page-title-box">
              <div class="btn-group float-right">
                  <ol class="breadcrumb hide-phone p-0 m-0">
                      <li class="breadcrumb-item"><a href="index.php">Laundry</a></li>
                      <li class="breadcrumb-item active">Data Transaksi Laundry</li>
                      <li class="breadcrumb-item active">Tambah</li>
                  </ol>
              </div>
              <h4 class="page-title">Tambah Transaksi Laundry</h4>
          </div>
      </div>
  </div>

  <div class="row">
      <div class="col-12">

      <?php if ($pesan_error !== "") : ?>
        <div class="alert alert-danger" role="alert">
          <?= $pesan_error; ?>
        </div>
      <?php endif; ?>

          <form action="" method="post">
          <div class="card m-b-100">
            <div class="card-body">

            <input type="hidden" name="userid" value="<?= $_SESSION['userid']; ?>">

            <?php 
            // mencari id_laundry otomatis
            $q = mysqli_query($conn, "SELECT MAX(RIGHT(id_laundry,4)) AS kd_max FROM tb_laundry");
            $kd = "0001";
            if (mysqli_num_rows($q) > 0) {
              $data = mysqli_fetch_assoc($q);
              $tmp = ((int)$data['kd_max']) + 1;
              $kd = sprintf("%04s", $tmp);
            }

            $id_laundry = 'LD-' . $kd;
            ?>

            <input type="hidden" name="id_laundry" value="<?= $id_laundry; ?>">

              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nama Pelanggan</label>
                <div class="col-sm-10">
                  <select name="pelangganid" class="select2 form-control" required>
                  <?php
                    $q2 = mysqli_query($conn, "SELECT * FROM tb_pelanggan");
                    while ($p = mysqli_fetch_assoc($q2)) :
                  ?>
                    <option value="<?= $p['pelangganid']; ?>" 
                      <?= ($p['pelangganid'] == $pelangganid) ? 'selected' : '' ?>>
                      <?= $p['pelanggannama']; ?>
                    </option>
                  <?php endwhile; ?>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Jenis Laundry</label>
                <div class="col-sm-10">
                  <select class="select2 form-control" name="id_jenis" id="id_jenis" onchange="jenis();" required>
                    <option value="">--Pilih jenis--</option>
                    <?php 
                    $qJenis = mysqli_query($conn, "SELECT * FROM tb_jenis");
                    while ($j = mysqli_fetch_assoc($qJenis)) :
                    ?>
                      <option value="<?= $j['kd_jenis']; ?>" 
                        <?= ($j['kd_jenis'] == $jenis) ? 'selected' : '' ?>>
                        <?= $j['jenis_laundry']; ?>
                      </option>
                    <?php endwhile; ?>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tarif (Hari)</label>
                <div class="col-sm-10">
                  <input class="form-control" type="text" id="tarif" name="tarif" value="<?= $tarif; ?>" required readonly/>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tgl. Selesai</label>
                <div class="col-sm-10">
                  <input class="form-control" type="text" id="tgl_selesai" name="tgl_selesai" value="<?= $tgl_selesai; ?>" required readonly />
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Jumlah (Kg)</label>
                <div class="col-sm-10">
                  <input class="form-control" type="number" id="jml_kilo" name="jml_kilo" value="<?= $jml_kilo; ?>" onkeyup="sum();" required/>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Total Bayar</label>
                <div class="col-sm-10">
                  <input class="form-control" type="number" value="<?= $totalbayar; ?>" id="totalbayar" name="totalbayar" readonly required/>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Catatan</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="catatan" cols="20" rows="5" required><?= $catatan; ?></textarea>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-10">
                  <select name="status" class="select2 form-control" required>
                    <option value="0" <?= ($status == 0) ? 'selected' : '' ?>>Belum lunas</option>
                    <option value="1" <?= ($status == 1) ? 'selected' : '' ?>>Lunas</option>
                  </select>
                </div>
              </div>

              <button type="submit" name="tambah" class="btn btn-primary"
                onclick="return confirm('Apakah data yang anda masukkan sudah benar ?');">Tambah</button>
              <a href="?page=pelanggan" class="btn btn-warning">Kembali</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<br>

<script>
// menghitung total bayar
function sum(){
    var jmlKilo = document.getElementById('jml_kilo').value;
    var tarif = document.getElementById('tarif').value;

    var total = parseInt(jmlKilo) * tarif;

    if (!isNaN(total)) {
        document.getElementById('totalbayar').value = total;
    } else {
        document.getElementById('totalbayar').value = '';
    }
}

function jenis(){
    var id = $("#id_jenis").val();

    $.ajax({
      url: "page/laundry/autofill.php",
      data: 'idjenis=' + id,
      success: function(data){
        var obj = JSON.parse(data);

        if (obj.sukses) {
          $('#tarif').val(obj.sukses.tarif);
          $('#tgl_selesai').val(obj.sukses.tgl_selesai);
          $('#jml_kilo').val('');
          $('#totalbayar').val('');
        } else {
          $('#tarif').val('');
          $('#tgl_selesai').val('');
          $('#jml_kilo').val('');
          $('#totalbayar').val('');
        }
      }
    });
}
</script>
