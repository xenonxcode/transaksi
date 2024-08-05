<?php
require 'koneksi.php';

// Mendapatkan ID dari parameter URL
$id = $_GET['id'];

// Menghapus data berdasarkan ID
$sql = "DELETE FROM transaksi WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Data berhasil dihapus!";
    header("Location: index.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
