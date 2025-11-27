<?php 
// Aktifkan mode exception MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Koneksi database
include 'koneksi.php';

// Inisialisasi variabel
$nama = $alamat = $pelanggantelp = $pelanggantgl_lahir = $pelangganemail = "";
$err_nama = $err_alamat = $err_telp = $err_tgl = $err_email = "";
$jk = "Laki - laki";

if (isset($_POST['tambah'])) {
    // Ambil data dari form
    $nama = trim($_POST["pelanggannama"]);
    $jk = $_POST["jk"] ?? "Laki - laki";
    $alamat = trim($_POST["alamat"]);
    $pelanggantelp = trim($_POST["pelanggantelp"]);
    $pelanggantgl_lahir = trim($_POST["pelanggantgl_lahir"]);
    $pelangganemail = trim($_POST["pelangganemail"]);

    // === Validasi Nama ===
    if ($nama === "") {
        $err_nama = "Nama wajib diisi!";
    } elseif (!preg_match("/^[A-Za-z\s]+$/", $nama)) {
        $err_nama = "Nama hanya boleh huruf dan spasi!";
    }

    // === Validasi Alamat ===
    if ($alamat === "") {
        $err_alamat = "Alamat wajib diisi!";
    }

    // === Validasi Nomor Telepon ===
    if ($pelanggantelp === "") {
        $err_telp = "No. Telp wajib diisi!";
    } else {
        if (!preg_match("/^\+/", $pelanggantelp)) {
            $err_telp = "No. Telp harus diawali tanda + (kode negara)!";
        } elseif (!preg_match("/^\+\d+$/", $pelanggantelp)) {
            $err_telp = "No. Telp hanya boleh berisi angka setelah tanda +!";
        } else {
            $digit_count = strlen(substr($pelanggantelp, 1)); // hitung tanpa tanda +
            if ($digit_count < 10) {
                $err_telp = "No. Telp terlalu pendek! Minimal 10 digit.";
            } elseif ($digit_count > 15) {
                $err_telp = "No. Telp terlalu panjang! Maksimal 15 digit.";
            }
        }
    }

    // === Validasi Tanggal Lahir ===
    if ($pelanggantgl_lahir === "") {
        $err_tgl = "Tanggal lahir wajib diisi!";
    }

    // === Validasi Email ===
    if ($pelangganemail === "") {
        $err_email = "Email wajib diisi!";
    } elseif (!filter_var($pelangganemail, FILTER_VALIDATE_EMAIL)) {
        $err_email = "Format email tidak valid!";
    }

    // === Jika Semua Validasi Aman, Simpan ke Database ===
    if (!$err_nama && !$err_alamat && !$err_telp && !$err_tgl && !$err_email) {
        try {
            $stmt = mysqli_prepare($conn, 
                "INSERT INTO tb_pelanggan 
                (pelanggannama, pelangganjk, pelangganalamat, pelanggantelp, pelanggantgl_lahir, pelangganemail) 
                VALUES (?, ?, ?, ?, ?, ?)"
            );
            mysqli_stmt_bind_param($stmt, "ssssss", $nama, $jk, $alamat, $pelanggantelp, $pelanggantgl_lahir, $pelangganemail);
            mysqli_stmt_execute($stmt);

            echo "<script>
                alert('Data dengan Nama $nama berhasil ditambahkan');
                window.location.href='?page=pelanggan';
            </script>";

        } catch (mysqli_sql_exception $e) {
            $err_msg = $e->getMessage();

            if (strpos($err_msg, "Data too long") !== false) {
                if (strpos($err_msg, "pelanggannama") !== false) $err_nama = "Nama pelanggan terlalu panjang!";
                elseif (strpos($err_msg, "pelangganalamat") !== false) $err_alamat = "Alamat terlalu panjang!";
                elseif (strpos($err_msg, "pelanggantelp") !== false) $err_telp = "No. Telp terlalu panjang!";
                elseif (strpos($err_msg, "pelangganemail") !== false) $err_email = "Email terlalu panjang!";
                else echo "<div class='alert alert-danger'>Beberapa data terlalu panjang!</div>";
            } else {
                echo "<div class='alert alert-danger'>Terjadi kesalahan: " . htmlspecialchars($err_msg) . "</div>";
            }
        }
    }
}
?>

<!-- =================== FORM =================== -->
<div class="page-content-wrapper">
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="index.php">Laundry</a></li>
                        <li class="breadcrumb-item active">Data Pelanggan</li>
                        <li class="breadcrumb-item active">Tambah Pelanggan</li>
                    </ol>
                </div>
                <h4 class="page-title">Tambah Pelanggan</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

        <form action="" method="post">
        <div class="card m-b-100">
            <div class="card-body">

                <!-- Nama -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama Pelanggan</label>
                    <div class="col-sm-10">
                        <input type="text" name="pelanggannama" class="form-control" 
                               value="<?= htmlspecialchars($nama); ?>" 
                               pattern="[A-Za-z\s]+" title="Nama hanya boleh huruf dan spasi"/>
                        <?php if ($err_nama) : ?>
                            <small class="text-danger"><?= $err_nama; ?></small>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Jenis Kelamin -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                    <div class="col-md-9">
                        <div class="form-check-inline my-1">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="customRadio4" name="jk" class="custom-control-input" 
                                       value="Laki - laki" <?= ($jk=="Laki - laki" || $jk=="") ? "checked" : ""; ?>>
                                <label class="custom-control-label" for="customRadio4">Laki - laki</label>
                            </div>
                        </div>
                        <div class="form-check-inline my-1">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="customRadio5" name="jk" class="custom-control-input" 
                                       value="Perempuan" <?= ($jk=="Perempuan") ? "checked" : ""; ?>>
                                <label class="custom-control-label" for="customRadio5">Perempuan</label>
                            </div>
                        </div>
                    </div>
                </div> 

                <!-- Alamat -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <textarea name="alamat" class="form-control"><?= htmlspecialchars($alamat); ?></textarea>
                        <?php if ($err_alamat) : ?>
                            <small class="text-danger"><?= $err_alamat; ?></small>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Telp -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Telp</label>
                    <div class="col-sm-10">
                        <input 
                            type="text" 
                            name="pelanggantelp" 
                            class="form-control" 
                            value="<?= htmlspecialchars($pelanggantelp); ?>" 
                />
                        <?php if ($err_telp) : ?>
                            <small class="text-danger"><?= $err_telp; ?></small>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Tanggal Lahir -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tanggal Lahir</label>
                    <div class="col-sm-10">
                        <input type="date" name="pelanggantgl_lahir" class="form-control" 
                               value="<?= htmlspecialchars($pelanggantgl_lahir); ?>" />
                        <?php if ($err_tgl) : ?>
                            <small class="text-danger"><?= $err_tgl; ?></small>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="pelangganemail" class="form-control" 
                               value="<?= htmlspecialchars($pelangganemail); ?>"/>
                        <?php if ($err_email) : ?>
                            <small class="text-danger"><?= $err_email; ?></small>
                        <?php endif; ?>
                    </div>
                </div>

                <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                <a href="?page=pelanggan" class="btn btn-warning">Kembali</a>

            </div>
        </div>
        </form>
        </div>
    </div>
</div>
</div>
<br>
