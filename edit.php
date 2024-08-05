<?php
require 'koneksi.php';

// Mendapatkan data berdasarkan ID
$id = $_GET['id'];
$sql = "SELECT * FROM transaksi WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Data tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Transaksi</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">Edit Data Transaksi</h2>
        <form id="transaksiForm" method="post" action="update.php">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <!-- Pembeli Section -->
            <h4>Pembeli</h4>
            <div class="form-group">
                <label for="nama_pembeli">Nama Pembeli</label>
                <input type="text" name="nama_pembeli" id="nama_pembeli" class="form-control" value="<?php echo $row['nama_pembeli']; ?>" required>
            </div>
            <div class="form-group">
                <label for="no_telpon_pembeli">No Telepon Pembeli</label>
                <input type="text" name="no_telpon_pembeli" id="no_telpon_pembeli" class="form-control" value="<?php echo $row['no_telpon_pembeli']; ?>" required>
            </div>

            <!-- Penerima Section -->
            <h4>Penerima</h4>
            <div class="form-group">
                <label for="nama_penerima">Nama Penerima</label>
                <input type="text" name="nama_penerima" id="nama_penerima" class="form-control" value="<?php echo $row['nama_penerima']; ?>" required>
            </div>
            <div class="form-group">
                <label for="no_telpon_penerima">No Telepon Penerima</label>
                <input type="text" name="no_telpon_penerima" id="no_telpon_penerima" class="form-control" value="<?php echo $row['no_telpon_penerima']; ?>" required>
            </div>
            <div class="form-group">
                <label for="alamat_jalan">Alamat Jalan</label>
                <input type="text" name="alamat_jalan" id="alamat_jalan" class="form-control" value="<?php echo $row['alamat_jalan']; ?>" required>
            </div>
            <div class="form-group">
                <label for="no_rumah">No Rumah</label>
                <input type="text" name="no_rumah" id="no_rumah" class="form-control" value="<?php echo $row['no_rumah']; ?>" required>
            </div>
            <div class="form-group">
                <label for="rt_rw">RT/RW</label>
                <input type="text" name="rt_rw" id="rt_rw" class="form-control" value="<?php echo $row['rt_rw']; ?>" required>
            </div>
            <div class="form-group">
                <label for="desa_kelurahan">Desa/Kelurahan</label>
                <input type="text" name="desa_kelurahan" id="desa_kelurahan" class="form-control" value="<?php echo $row['desa_kelurahan']; ?>" required>
            </div>
            <div class="form-group">
                <label for="kecamatan">Kecamatan</label>
                <input type="text" name="kecamatan" id="kecamatan" class="form-control" value="<?php echo $row['kecamatan']; ?>" required>
            </div>
            <div class="form-group">
                <label for="kabupaten_kota">Kabupaten/Kota</label>
                <input type="text" name="kabupaten_kota" id="kabupaten_kota" class="form-control" value="<?php echo $row['kabupaten_kota']; ?>" required>
            </div>
            <div class="form-group">
                <label for="provinsi">Provinsi</label>
                <input type="text" name="provinsi" id="provinsi" class="form-control" value="<?php echo $row['provinsi']; ?>" required>
            </div>

            <!-- Pembayaran Section -->
            <h4>Pembayaran</h4>
            <div class="form-group">
                <label for="dp_tanggal">Tanggal DP</label>
                <input type="date" name="dp_tanggal" id="dp_tanggal" class="form-control" value="<?php echo $row['dp_tanggal']; ?>" required>
            </div>
            <div class="form-group">
                <label for="dp_nominal">Nominal DP (Rupiah)</label>
                <input type="number" name="dp_nominal" id="dp_nominal" class="form-control" value="<?php echo $row['dp_nominal']; ?>" required>
            </div>
            <div class="form-group">
                <label for="pelunasan_tanggal">Tanggal Pelunasan</label>
                <input type="date" name="pelunasan_tanggal" id="pelunasan_tanggal" class="form-control" value="<?php echo $row['pelunasan_tanggal']; ?>" required>
            </div>
            <div class="form-group">
                <label for="pelunasan_nominal">Nominal Pelunasan (Rupiah)</label>
                <input type="number" name="pelunasan_nominal" id="pelunasan_nominal" class="form-control" value="<?php echo $row['pelunasan_nominal']; ?>" required>
            </div>

            <!-- Pengiriman Section -->
            <h4>Pengiriman</h4>
            <div class="form-group">
                <label for="tanggal_pengiriman">Tanggal Pengiriman</label>
                <input type="date" name="tanggal_pengiriman" id="tanggal_pengiriman" class="form-control" value="<?php echo $row['tanggal_pengiriman']; ?>" required>
            </div>
            <div class="form-group">
                <label for="jam_pengiriman">Jam Pengiriman</label>
                <input type="time" name="jam_pengiriman" id="jam_pengiriman" class="form-control" value="<?php echo $row['jam_pengiriman']; ?>" required>
            </div>
            <div class="form-group">
                <label for="no_telpon_pengirim">No Telepon Pengirim</label>
                <input type="text" name="no_telpon_pengirim" id="no_telpon_pengirim" class="form-control" value="<?php echo $row['no_telpon_pengirim']; ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Data</button>
        </form>
    </div>

    <!-- jQuery dan Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
