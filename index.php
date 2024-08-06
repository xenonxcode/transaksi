<?php
require 'koneksi.php';

// Inisialisasi variabel pencarian
$searchTerm = '';

// Cek apakah form pencarian di-submit
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
}

// Query untuk mengambil data dari database dengan pencarian
$sql = "SELECT * FROM transaksi WHERE 
        nama_pembeli LIKE '%$searchTerm%' 
        OR nama_penerima LIKE '%$searchTerm%' 
        OR id LIKE '%$searchTerm%'
        OR nama_pengirim LIKE '%$searchTerm%'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Management Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-box {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        input[type="text"] {
            width: 300px;
            padding: 10px;
            margin-right: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            border-radius: 4px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .actions a {
            margin-right: 10px;
            text-decoration: none;
            color: #007BFF;
        }

        .actions a:hover {
            text-decoration: underline;
        }

        .export-buttons {
            text-align: center;
            margin-bottom: 20px;
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
        <h1>Data Management Dashboard</h1>

        <!-- Form Pencarian -->
        <div class="search-box">
            <form action="index.php" method="GET">
                <input type="text" name="search" placeholder="Cari berdasarkan Nama/ID/Nama Pengirim" value="<?php echo $searchTerm; ?>">
                <input type="submit" value="Cari">
            </form>
        </div>

        <!-- Tabel Data -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Pembeli</th>
                        <th>No Telpon Pembeli</th>
                        <th>Nama Penerima</th>
                        <th>No Telpon Penerima</th>
                        <th>Alamat</th>
                        <th>DP (Tanggal)</th>
                        <th>DP (Nominal)</th>
                        <th>Pelunasan (Tanggal)</th>
                        <th>Pelunasan (Nominal)</th>
                        <th>Total Harga</th>
                        <th>Untung</th>
                        <th>Rugi</th>
                        <th>Nama Pengirim</th> 
                        <th>Tanggal Pengiriman</th>
                        <th>Jam Pengiriman</th>
                        <th>No Telpon Pengirim</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . $row['id'] . "</td>
                                <td>" . $row['nama_pembeli'] . "</td>
                                <td>" . $row['no_telpon_pembeli'] . "</td>
                                <td>" . $row['nama_penerima'] . "</td>
                                <td>" . $row['no_telpon_penerima'] . "</td>
                                <td>" . $row['alamat_jalan'] . " No. " . $row['no_rumah'] . " RT/RW " . $row['rt_rw'] . " " . $row['desa_kelurahan'] . ", " . $row['kecamatan'] . ", " . $row['kabupaten_kota'] . ", " . $row['provinsi'] . "</td>
                                <td>" . $row['dp_tanggal'] . "</td>
                                <td>Rp" . number_format($row['dp_nominal'], 0, ',', '.') . "</td>
                                <td>" . $row['pelunasan_tanggal'] . "</td>
                                <td>Rp" . number_format($row['pelunasan_nominal'], 0, ',', '.') . "</td>
                                <td>Rp" . number_format($row['total_harga'], 0, ',', '.') . "</td>
                                <td>Rp" . number_format($row['untung'], 0, ',', '.') . "</td>
                                <td>Rp" . number_format($row['rugi'], 0, ',', '.') . "</td>
                                <td>" . $row['nama_pengirim'] . "</td> <!-- Nama Pengirim -->
                                <td>" . $row['tanggal_pengiriman'] . "</td>
                                <td>" . $row['jam_pengiriman'] . "</td>
                                <td>" . $row['no_telpon_pengirim'] . "</td>
                                <td class='actions'>
                                    <a href='edit.php?id=" . $row['id'] . "'>Edit</a>
                                    <a href='delete.php?id=" . $row['id'] . "' onclick=\"return confirm('Anda yakin ingin menghapus data ini?');\">Delete</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='18'>Tidak ada data ditemukan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Tombol Export -->
        <div class="export-buttons">
    <a href="export_pdf.php" class="btn btn-danger btn-custom"><i class="bi bi-file-earmark-pdf"></i> Export to PDF</a>
    <a href="export_excel.php" class="btn btn-success btn-custom"><i class="bi bi-file-earmark-excel"></i> Export to Excel</a>
    <a href="laporan_keuangan.php" class="btn btn-info btn-custom"><i class="bi bi-graph-up"></i> Laporan Keuangan</a>
</div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
