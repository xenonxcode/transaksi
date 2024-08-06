<?php
require 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pembeli = $_POST['nama_pembeli'];
    $no_telpon_pembeli = $_POST['no_telpon_pembeli'];
    $nama_penerima = $_POST['nama_penerima'];
    $no_telpon_penerima = $_POST['no_telpon_penerima'];
    $alamat_jalan = $_POST['alamat_jalan'];
    $no_rumah = $_POST['no_rumah'];
    $rt_rw = $_POST['rt_rw'];
    $desa_kelurahan = $_POST['desa_kelurahan'];
    $kecamatan = $_POST['kecamatan'];
    $kabupaten_kota = $_POST['kabupaten_kota'];
    $provinsi = $_POST['provinsi'];
    $dp_tanggal = $_POST['dp_tanggal'];
    $dp_nominal = $_POST['dp_nominal'];
    $pelunasan_tanggal = $_POST['pelunasan_tanggal'];
    $pelunasan_nominal = $_POST['pelunasan_nominal'] ?: 0; // Optional field
    $total_harga = $_POST['total_harga'];
    $tanggal_pengiriman = $_POST['tanggal_pengiriman'];
    $jam_pengiriman = $_POST['jam_pengiriman'];
    $nama_pengirim = $_POST['nama_pengirim']; // Nama Pengirim baru
    $no_telpon_pengirim = $_POST['no_telpon_pengirim'];

    // Kalkulasi untung/rugi
    $untung = max(0, $pelunasan_nominal + $dp_nominal - $total_harga);
    $rugi = max(0, $total_harga - ($pelunasan_nominal + $dp_nominal));

    // Menyimpan data ke database
    $sql = "INSERT INTO transaksi (
                nama_pembeli, no_telpon_pembeli, nama_penerima, no_telpon_penerima,
                alamat_jalan, no_rumah, rt_rw, desa_kelurahan, kecamatan, kabupaten_kota,
                provinsi, dp_tanggal, dp_nominal, pelunasan_tanggal, pelunasan_nominal,
                total_harga, untung, rugi, nama_pengirim, no_telpon_pengirim, tanggal_pengiriman, jam_pengiriman
            ) VALUES (
                '$nama_pembeli', '$no_telpon_pembeli', '$nama_penerima', '$no_telpon_penerima',
                '$alamat_jalan', '$no_rumah', '$rt_rw', '$desa_kelurahan', '$kecamatan', '$kabupaten_kota',
                '$provinsi', '$dp_tanggal', '$dp_nominal', '$pelunasan_tanggal', '$pelunasan_nominal',
                '$total_harga', '$untung', '$rugi', '$nama_pengirim', '$no_telpon_pengirim', '$tanggal_pengiriman', '$jam_pengiriman'
            )";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil disimpan!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Transaksi</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 700px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .btn-custom {
            border-radius: 50px;
            font-size: 1rem;
            padding: 10px 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Tambah Data Transaksi</h2>
        <form action="add.php" method="POST">
            <!-- Informasi Pembeli -->
            <div class="mb-3">
                <label for="nama_pembeli" class="form-label">Nama Pembeli</label>
                <input type="text" class="form-control" id="nama_pembeli" name="nama_pembeli" required>
            </div>
            <div class="mb-3">
                <label for="no_telpon_pembeli" class="form-label">No Telpon Pembeli</label>
                <input type="text" class="form-control" id="no_telpon_pembeli" name="no_telpon_pembeli" required>
            </div>

            <!-- Informasi Penerima -->
            <div class="mb-3">
                <label for="nama_penerima" class="form-label">Nama Penerima</label>
                <input type="text" class="form-control" id="nama_penerima" name="nama_penerima" required>
            </div>
            <div class="mb-3">
                <label for="no_telpon_penerima" class="form-label">No Telpon Penerima</label>
                <input type="text" class="form-control" id="no_telpon_penerima" name="no_telpon_penerima" required>
            </div>
            <div class="mb-3">
                <label for="alamat_jalan" class="form-label">Alamat Jalan</label>
                <input type="text" class="form-control" id="alamat_jalan" name="alamat_jalan" required>
            </div>
            <div class="mb-3">
                <label for="no_rumah" class="form-label">No. Rumah</label>
                <input type="text" class="form-control" id="no_rumah" name="no_rumah" required>
            </div>
            <div class="mb-3">
                <label for="rt_rw" class="form-label">RT/RW</label>
                <input type="text" class="form-control" id="rt_rw" name="rt_rw" required>
            </div>
            <div class="mb-3">
                <label for="desa_kelurahan" class="form-label">Desa/Kelurahan</label>
                <input type="text" class="form-control" id="desa_kelurahan" name="desa_kelurahan" required>
            </div>
            <div class="mb-3">
                <label for="kecamatan" class="form-label">Kecamatan</label>
                <input type="text" class="form-control" id="kecamatan" name="kecamatan" required>
            </div>
            <div class="mb-3">
                <label for="kabupaten_kota" class="form-label">Kabupaten/Kota</label>
                <input type="text" class="form-control" id="kabupaten_kota" name="kabupaten_kota" required>
            </div>
            <div class="mb-3">
                <label for="provinsi" class="form-label">Provinsi</label>
                <input type="text" class="form-control" id="provinsi" name="provinsi" required>
            </div>

            <!-- Informasi Pembayaran -->
            <div class="mb-3">
                <label for="dp_tanggal" class="form-label">DP Tanggal</label>
                <input type="date" class="form-control" id="dp_tanggal" name="dp_tanggal" required>
            </div>
            <div class="mb-3">
                <label for="dp_nominal" class="form-label">DP Nominal (Rp)</label>
                <input type="number" class="form-control" id="dp_nominal" name="dp_nominal" required>
            </div>
            <div class="mb-3">
                <label for="pelunasan_tanggal" class="form-label">Pelunasan Tanggal (Optional)</label>
                <input type="date" class="form-control" id="pelunasan_tanggal" name="pelunasan_tanggal">
            </div>
            <div class="mb-3">
                <label for="pelunasan_nominal" class="form-label">Pelunasan Nominal (Rp) (Optional)</label>
                <input type="number" class="form-control" id="pelunasan_nominal" name="pelunasan_nominal">
            </div>
            <div class="mb-3">
                <label for="total_harga" class="form-label">Total Harga (Rp)</label>
                <input type="number" class="form-control" id="total_harga" name="total_harga" required>
            </div>

            <!-- Informasi Pengiriman -->
            <div class="mb-3">
                <label for="tanggal_pengiriman" class="form-label">Tanggal Pengiriman</label>
                <input type="date" class="form-control" id="tanggal_pengiriman" name="tanggal_pengiriman" required>
            </div>
            <div class="mb-3">
                <label for="jam_pengiriman" class="form-label">Jam Pengiriman</label>
                <input type="time" class="form-control" id="jam_pengiriman" name="jam_pengiriman" required>
            </div>
            <div class="mb-3">
                <label for="nama_pengirim" class="form-label">Nama Pengirim/Kurir</label>
                <input type="text" class="form-control" id="nama_pengirim" name="nama_pengirim" required>
            </div>
            <div class="mb-3">
                <label for="no_telpon_pengirim" class="form-label">No Telpon Pengirim</label>
                <input type="text" class="form-control" id="no_telpon_pengirim" name="no_telpon_pengirim" required>
            </div>

            <!-- Tombol Submit -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-custom"><i class="bi bi-plus-circle-fill"></i> Tambah Data</button>
            </div>
        </form>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
