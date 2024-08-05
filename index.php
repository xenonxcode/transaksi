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
        OR id LIKE '%$searchTerm%'";

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
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .search-box {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .btn-custom {
            border-radius: 50px;
            font-size: 1rem;
            padding: 10px 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
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
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .actions a {
            margin-right: 10px;
            text-decoration: none;
            color: #007BFF;
        }

        .actions a:hover {
            text-decoration: underline;
        }

        .table-responsive {
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .search-box {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Data Management Dashboard</h1>

        <!-- Form Pencarian -->
        <div class="search-box">
            <form class="d-flex" action="index.php" method="GET">
                <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan Nama/ID" value="<?php echo htmlspecialchars($searchTerm); ?>">
                <input type="submit" class="btn btn-primary" value="Cari">
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
                            <td>" . $row['tanggal_pengiriman'] . "</td>
                            <td>" . $row['jam_pengiriman'] . "</td>
                            <td>" . $row['no_telpon_pengirim'] . "</td>
                            <td class='actions'>
                                <a href='edit.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?')\">Delete</a>
                            </td>
                        </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='17' class='text-center'>Tidak ada data ditemukan</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Tombol Ekspor -->
        <div class="d-flex justify-content-end">
            <a href="export_excel.php" class="btn btn-success btn-custom">
                <i class="bi bi-file-earmark-excel-fill"></i> Export to Excel
            </a>
            <a href="export_pdf.php" class="btn btn-danger btn-custom">
                <i class="bi bi-file-earmark-pdf-fill"></i> Export to PDF
            </a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>

</html>

<?php $conn->close(); ?>
