<?php
require 'koneksi.php';

// Mendapatkan rentang tanggal jika diperlukan
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');

// Query untuk mendapatkan data keuangan dari database
$sql = "SELECT 
    SUM(dp_nominal + pelunasan_nominal) as total_pendapatan, 
    SUM(total_harga) as total_harga_pokok_penjualan,
    SUM(untung) as total_untung,
    SUM(rugi) as total_rugi
    FROM transaksi
    WHERE tanggal_pengiriman BETWEEN '$startDate' AND '$endDate'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalPendapatan = $row['total_pendapatan'];
    $totalHargaPokokPenjualan = $row['total_harga_pokok_penjualan'];
    $totalUntung = $row['total_untung'];
    $totalRugi = $row['total_rugi'];
} else {
    $totalPendapatan = 0;
    $totalHargaPokokPenjualan = 0;
    $totalUntung = 0;
    $totalRugi = 0;
}

// Kalkulasi Laba Kotor dan Laba Bersih
$totalLabaKotor = $totalPendapatan - $totalHargaPokokPenjualan;
$totalLabaBersih = $totalLabaKotor - $totalRugi;

// Menutup koneksi database
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #007BFF;
            margin-bottom: 10px;
        }

        h2 {
            color: #555;
            margin-top: 40px;
            margin-bottom: 10px;
        }

        .report-header {
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        th {
            background-color: #f2f2f2;
        }

        .total-row {
            background-color: #f9f9f9;
            font-weight: bold;
        }

        .highlight {
            color: #007BFF;
            font-weight: bold;
        }

        .chart-container {
            width: 100%;
            height: 400px;
            margin-bottom: 50px;
        }
        .export-buttons {
        text-align: center;
        margin-top: 20px;
    }

    .btn {
        display: inline-block;
        padding: 10px 15px;
        font-size: 16px;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        outline: none;
        color: #fff;
        background-color: #4CAF50;
        border: none;
        border-radius: 15px;
        box-shadow: 0 9px #999;
    }

    .btn:hover {background-color: #3e8e41}

    .btn:active {
        background-color: #3e8e41;
        box-shadow: 0 5px #666;
        transform: translateY(4px);
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="report-header">
            <h1>Laporan Laba & Rugi</h1>
            <p>Project Mbak Sendy</p>
            <div class="export-buttons">
                <a href="export_to_pdf.php?start_date=<?php echo urlencode($startDate); ?>&end_date=<?php echo urlencode($endDate); ?>" class="btn btn-primary">Export to PDF</a>
            </div>
            <form>
                <label for="start_date">Tanggal Mulai:</label>
                <input type="date" id="start_date" name="start_date" value="<?php echo $startDate;?>">
                <label for="end_date">Tanggal Akhir:</label>
                <input type="date" id="end_date" name="end_date" value="<?php echo $endDate;?>">
                <button type="submit">Tampilkan</button>
            </form>
            <p>Dari <?php echo date('d M Y', strtotime($startDate)); ?> sampai <?php echo date('d M Y', strtotime($endDate)); ?></p>
        </div>

        <!-- Grafik Laporan -->
        <div class="chart-container">
            <canvas id="financialChart"></canvas>
        </div>

        <!-- Tabel Laporan Keuangan -->
        <h2>Pendapatan</h2>
        <table>
            <tr>
                <td>Pendapatan Jasa</td>
                <td class="highlight">Rp<?php echo number_format($totalPendapatan, 0, ',', '.'); ?></td>
            </tr>
            <tr class="total-row">
                <td>Total Pendapatan</td>
                <td class="highlight">Rp<?php echo number_format($totalPendapatan, 0, ',', '.'); ?></td>
            </tr>
        </table>

        <h2>Harga Pokok Penjualan</h2>
        <table>
            <tr>
                <td>Harga Pokok Penjualan</td>
                <td class="highlight">Rp<?php echo number_format($totalHargaPokokPenjualan, 0, ',', '.'); ?></td>
            </tr>
            <tr class="total-row">
                <td>Total Harga Pokok Penjualan</td>
                <td class="highlight">(Rp<?php echo number_format($totalHargaPokokPenjualan, 0, ',', '.'); ?>)</td>
            </tr>
        </table>

        <h2>Total Laba Kotor</h2>
        <table>
            <tr class="total-row">
                <td>Total Laba Kotor</td>
                <td class="highlight">Rp<?php echo number_format($totalLabaKotor, 0, ',', '.'); ?></td>
            </tr>
        </table>

        <h2>Beban Operasional</h2>
        <table>
            <tr>
                <td>Rugi</td>
                <td class="highlight">Rp<?php echo number_format($totalRugi, 0, ',', '.'); ?></td>
            </tr>
            <tr class="total-row">
                <td>Total Beban Operasional</td>
                <td class="highlight">(Rp<?php echo number_format($totalRugi, 0, ',', '.'); ?>)</td>
            </tr>
        </table>

        <h2>Laba Bersih Operasional</h2>
        <table>
            <tr class="total-row">
                <td>Laba Bersih Operasional</td>
                <td class="highlight">Rp<?php echo number_format($totalLabaBersih, 0, ',', '.'); ?></td>
            </tr>
        </table>

        <h2>Pendapatan & Beban Lainnya</h2>
        <table>
            <tr>
                <td>Untung</td>
                <td class="highlight">Rp<?php echo number_format($totalUntung, 0, ',', '.'); ?></td>
            </tr>
            <tr class="total-row">
                <td>Total Pendapatan & Beban Lainnya</td>
                <td class="highlight">Rp0</td>
            </tr>
        </table>

        <h2>Laba/(Rugi) Bersih</h2>
        <table>
            <tr class="total-row">
                <td>Laba/(Rugi) Bersih</td>
                <td class="highlight">Rp<?php echo number_format($totalLabaBersih + $totalUntung, 0, ',', '.'); ?></td>
            </tr>
        </table>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('financialChart').getContext('2d');
        const financialChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Pendapatan', 'Harga Pokok Penjualan', 'Laba Kotor', 'Rugi', 'Untung', 'Laba Bersih'],
                datasets: [{
                    label: 'Rupiah (IDR)',
                    data: [
                        <?php echo $totalPendapatan; ?>,
                        -<?php echo $totalHargaPokokPenjualan; ?>,
                        <?php echo $totalLabaKotor; ?>,
                        -<?php echo $totalRugi; ?>,
                        <?php echo $totalUntung; ?>,
                        <?php echo $totalLabaBersih + $totalUntung; ?>
                    ],
                    backgroundColor: [
                        '#4CAF50',
                        '#F44336',
                        '#2196F3',
                        '#FFC107',
                        '#009688',
                        '#9C27B0'
                    ],
                    borderColor: [
                        '#4CAF50',
                        '#F44336',
                        '#2196F3',
                        '#FFC107',
                        '#009688',
                        '#9C27B0'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });
    </script>
</body>

</html>
