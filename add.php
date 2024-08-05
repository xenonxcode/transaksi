<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
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
    
    // Ubah pelunasan menjadi opsional
    $pelunasan_tanggal = !empty($_POST['pelunasan_tanggal']) ? $_POST['pelunasan_tanggal'] : NULL;
    $pelunasan_nominal = !empty($_POST['pelunasan_nominal']) ? $_POST['pelunasan_nominal'] : 0;
    
    // Ambil nilai total harga
    $total_harga = $_POST['total_harga'];
    
    // Hitung untung dan rugi
    $total_dibayar = $dp_nominal + $pelunasan_nominal;
    $untung = $total_dibayar - $total_harga;
    $rugi = ($total_harga > $total_dibayar) ? $total_harga - $total_dibayar : 0;
    
    $tanggal_pengiriman = $_POST['tanggal_pengiriman'];
    $jam_pengiriman = $_POST['jam_pengiriman'];
    $no_telpon_pengirim = $_POST['no_telpon_pengirim'];
    
    // Query untuk menyimpan data ke database
    $sql = "INSERT INTO transaksi 
            (nama_pembeli, no_telpon_pembeli, nama_penerima, no_telpon_penerima, alamat_jalan, no_rumah, rt_rw, desa_kelurahan, kecamatan, kabupaten_kota, provinsi, dp_tanggal, dp_nominal, pelunasan_tanggal, pelunasan_nominal, total_harga, untung, rugi, tanggal_pengiriman, jam_pengiriman, no_telpon_pengirim)
            VALUES 
            ('$nama_pembeli', '$no_telpon_pembeli', '$nama_penerima', '$no_telpon_penerima', '$alamat_jalan', '$no_rumah', '$rt_rw', '$desa_kelurahan', '$kecamatan', '$kabupaten_kota', '$provinsi', '$dp_tanggal', '$dp_nominal', 
            ".($pelunasan_tanggal ? "'$pelunasan_tanggal'" : "NULL").", 
            '$pelunasan_nominal', '$total_harga', '$untung', '$rugi', '$tanggal_pengiriman', '$jam_pengiriman', '$no_telpon_pengirim')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil ditambahkan";
        header('Location: index.php'); // Redirect ke halaman utama setelah sukses menambahkan data
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f9f9f9;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: auto;
        }
        input[type="text"], input[type="number"], input[type="date"], input[type="time"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Tambah Data Pembelian</h2>
    <form action="add.php" method="POST">
        <h3>Pembeli</h3>
        <label for="nama_pembeli">Nama Pembeli:</label>
        <input type="text" name="nama_pembeli" id="nama_pembeli" required>
        
        <label for="no_telpon_pembeli">No Telepon Pembeli:</label>
        <input type="text" name="no_telpon_pembeli" id="no_telpon_pembeli" required>
        
        <h3>Penerima</h3>
        <label for="nama_penerima">Nama Penerima:</label>
        <input type="text" name="nama_penerima" id="nama_penerima" required>
        
        <label for="no_telpon_penerima">No Telepon Penerima:</label>
        <input type="text" name="no_telpon_penerima" id="no_telpon_penerima" required>
        
        <label for="alamat_jalan">Alamat (Jalan):</label>
        <input type="text" name="alamat_jalan" id="alamat_jalan" required>
        
        <label for="no_rumah">No Rumah:</label>
        <input type="text" name="no_rumah" id="no_rumah" required>
        
        <label for="rt_rw">RT/RW:</label>
        <input type="text" name="rt_rw" id="rt_rw" required>
        
        <label for="desa_kelurahan">Desa/Kelurahan:</label>
        <input type="text" name="desa_kelurahan" id="desa_kelurahan" required>
        
        <label for="kecamatan">Kecamatan:</label>
        <input type="text" name="kecamatan" id="kecamatan" required>
        
        <label for="kabupaten_kota">Kabupaten/Kota:</label>
        <input type="text" name="kabupaten_kota" id="kabupaten_kota" required>
        
        <label for="provinsi">Provinsi:</label>
        <input type="text" name="provinsi" id="provinsi" required>
        
        <h3>Pembayaran</h3>
        <label for="dp_tanggal">DP (Tanggal):</label>
        <input type="date" name="dp_tanggal" id="dp_tanggal" required>
        
        <label for="dp_nominal">DP (Nominal Rupiah):</label>
        <input type="number" name="dp_nominal" id="dp_nominal" required>
        
        <!-- Pelunasan menjadi opsional -->
        <label for="pelunasan_tanggal">Pelunasan (Tanggal - Opsional):</label>
        <input type="date" name="pelunasan_tanggal" id="pelunasan_tanggal">
        
        <label for="pelunasan_nominal">Pelunasan (Nominal Rupiah - Opsional):</label>
        <input type="number" name="pelunasan_nominal" id="pelunasan_nominal">
        
        <label for="total_harga">Total Harga (Rupiah):</label>
        <input type="number" name="total_harga" id="total_harga" required>
        
        <h3>Pengiriman</h3>
        <label for="tanggal_pengiriman">Tanggal Pengiriman:</label>
        <input type="date" name="tanggal_pengiriman" id="tanggal_pengiriman" required>
        
        <label for="jam_pengiriman">Jam Pengiriman:</label>
        <input type="time" name="jam_pengiriman" id="jam_pengiriman" required>
        
        <label for="no_telpon_pengirim">No Telepon Pengirim:</label>
        <input type="text" name="no_telpon_pengirim" id="no_telpon_pengirim" required>
        
        <input type="submit" value="Tambah Data">
    </form>
</body>
</html>
