<?php
require 'koneksi.php';

// Mendapatkan data dari form
$id = $_POST['id'];
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
$pelunasan_nominal = $_POST['pelunasan_nominal'];
$tanggal_pengiriman = $_POST['tanggal_pengiriman'];
$jam_pengiriman = $_POST['jam_pengiriman'];
$no_telpon_pengirim = $_POST['no_telpon_pengirim'];

// Kalkulasi untung dan rugi
$total_pembayaran = $dp_nominal + $pelunasan_nominal;
$untung = ($total_pembayaran > 500000) ? $total_pembayaran * 0.1 : $total_pembayaran * 0.05;
$rugi = ($total_pembayaran < 500000) ? 500000 - $total_pembayaran : 0;

// Mengupdate data di database
$sql = "UPDATE transaksi SET 
            nama_pembeli='$nama_pembeli', no_telpon_pembeli='$no_telpon_pembeli',
            nama_penerima='$nama_penerima', no_telpon_penerima='$no_telpon_penerima',
            alamat_jalan='$alamat_jalan', no_rumah='$no_rumah', rt_rw='$rt_rw',
            desa_kelurahan='$desa_kelurahan', kecamatan='$kecamatan', kabupaten_kota='$kabupaten_kota',
            provinsi='$provinsi', dp_tanggal='$dp_tanggal', dp_nominal=$dp_nominal,
            pelunasan_tanggal='$pelunasan_tanggal', pelunasan_nominal=$pelunasan_nominal,
            untung=$untung, rugi=$rugi, tanggal_pengiriman='$tanggal_pengiriman',
            jam_pengiriman='$jam_pengiriman', no_telpon_pengirim='$no_telpon_pengirim'
        WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Data berhasil diupdate!";
    header("Location: index.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
