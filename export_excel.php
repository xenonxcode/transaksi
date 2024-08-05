<?php
require 'koneksi.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set header
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Nama Pembeli');
$sheet->setCellValue('C1', 'No Telpon Pembeli');
$sheet->setCellValue('D1', 'Nama Penerima');
$sheet->setCellValue('E1', 'No Telpon Penerima');
$sheet->setCellValue('F1', 'Alamat');
$sheet->setCellValue('G1', 'DP (Tanggal)');
$sheet->setCellValue('H1', 'DP (Nominal)');
$sheet->setCellValue('I1', 'Pelunasan (Tanggal)');
$sheet->setCellValue('J1', 'Pelunasan (Nominal)');
$sheet->setCellValue('K1', 'Total Harga');
$sheet->setCellValue('L1', 'Untung');
$sheet->setCellValue('M1', 'Rugi');
$sheet->setCellValue('N1', 'Tanggal Pengiriman');
$sheet->setCellValue('O1', 'Jam Pengiriman');
$sheet->setCellValue('P1', 'No Telpon Pengirim');

// Fetch data
$sql = "SELECT * FROM transaksi";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $rowNumber = 2; // Start from the second row
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNumber, $row['id']);
        $sheet->setCellValue('B' . $rowNumber, $row['nama_pembeli']);
        $sheet->setCellValue('C' . $rowNumber, $row['no_telpon_pembeli']);
        $sheet->setCellValue('D' . $rowNumber, $row['nama_penerima']);
        $sheet->setCellValue('E' . $rowNumber, $row['no_telpon_penerima']);
        $sheet->setCellValue('F' . $rowNumber, $row['alamat_jalan'] . " No. " . $row['no_rumah'] . " RT/RW " . $row['rt_rw'] . " " . $row['desa_kelurahan'] . ", " . $row['kecamatan'] . ", " . $row['kabupaten_kota'] . ", " . $row['provinsi']);
        $sheet->setCellValue('G' . $rowNumber, $row['dp_tanggal']);
        $sheet->setCellValue('H' . $rowNumber, $row['dp_nominal']);
        $sheet->setCellValue('I' . $rowNumber, $row['pelunasan_tanggal']);
        $sheet->setCellValue('J' . $rowNumber, $row['pelunasan_nominal']);
        $sheet->setCellValue('K' . $rowNumber, $row['total_harga']);
        $sheet->setCellValue('L' . $rowNumber, $row['untung']);
        $sheet->setCellValue('M' . $rowNumber, $row['rugi']);
        $sheet->setCellValue('N' . $rowNumber, $row['tanggal_pengiriman']);
        $sheet->setCellValue('O' . $rowNumber, $row['jam_pengiriman']);
        $sheet->setCellValue('P' . $rowNumber, $row['no_telpon_pengirim']);
        $rowNumber++;
    }
}

// Write to .xlsx file
$writer = new Xlsx($spreadsheet);
$filename = 'data-transaksi.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'. $filename .'"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
?>
