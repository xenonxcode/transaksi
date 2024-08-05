<?php
require 'koneksi.php';
require 'vendor/autoload.php'; // Memuat autoloader Composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;

// Buat Spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Atur orientasi halaman menjadi lanskap
$spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);

// Menambahkan judul dengan gaya
$sheet->mergeCells('A1:P1');
$sheet->setCellValue('A1', 'Laporan Transaksi');
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Menambahkan header tabel dengan gaya
$headerStyle = [
    'font' => [
        'bold' => true,
        'color' => ['argb' => 'FFFFFF'],
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['argb' => '4CAF50'],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => '000000'],
        ],
    ],
];

$sheet->getStyle('A2:P2')->applyFromArray($headerStyle);

$sheet->setCellValue('A2', 'ID');
$sheet->setCellValue('B2', 'Nama Pembeli');
$sheet->setCellValue('C2', 'No Telpon Pembeli');
$sheet->setCellValue('D2', 'Nama Penerima');
$sheet->setCellValue('E2', 'No Telpon Penerima');
$sheet->setCellValue('F2', 'Alamat');
$sheet->setCellValue('G2', 'DP (Tanggal)');
$sheet->setCellValue('H2', 'DP (Nominal)');
$sheet->setCellValue('I2', 'Pelunasan (Tanggal)');
$sheet->setCellValue('J2', 'Pelunasan (Nominal)');
$sheet->setCellValue('K2', 'Total Harga');
$sheet->setCellValue('L2', 'Untung');
$sheet->setCellValue('M2', 'Rugi');
$sheet->setCellValue('N2', 'Tanggal Pengiriman');
$sheet->setCellValue('O2', 'Jam Pengiriman');
$sheet->setCellValue('P2', 'No Telpon Pengirim');

// Fetch data
$sql = "SELECT * FROM transaksi";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $rowNumber = 3; // Start from the third row
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNumber, $row['id']);
        $sheet->setCellValue('B' . $rowNumber, $row['nama_pembeli']);
        $sheet->setCellValue('C' . $rowNumber, $row['no_telpon_pembeli']);
        $sheet->setCellValue('D' . $rowNumber, $row['nama_penerima']);
        $sheet->setCellValue('E' . $rowNumber, $row['no_telpon_penerima']);
        $sheet->setCellValue('F' . $rowNumber, $row['alamat_jalan'] . " No. " . $row['no_rumah'] . " RT/RW " . $row['rt_rw'] . " " . $row['desa_kelurahan'] . ", " . $row['kecamatan'] . ", " . $row['kabupaten_kota'] . ", " . $row['provinsi']);
        $sheet->setCellValue('G' . $rowNumber, $row['dp_tanggal']);
        $sheet->setCellValue('H' . $rowNumber, number_format($row['dp_nominal'], 0, ',', '.'));
        $sheet->setCellValue('I' . $rowNumber, $row['pelunasan_tanggal']);
        $sheet->setCellValue('J' . $rowNumber, number_format($row['pelunasan_nominal'], 0, ',', '.'));
        $sheet->setCellValue('K' . $rowNumber, number_format($row['total_harga'], 0, ',', '.'));
        $sheet->setCellValue('L' . $rowNumber, number_format($row['untung'], 0, ',', '.'));
        $sheet->setCellValue('M' . $rowNumber, number_format($row['rugi'], 0, ',', '.'));
        $sheet->setCellValue('N' . $rowNumber, $row['tanggal_pengiriman']);
        $sheet->setCellValue('O' . $rowNumber, $row['jam_pengiriman']);
        $sheet->setCellValue('P' . $rowNumber, $row['no_telpon_pengirim']);
        
        // Gaya baris selang-seling
        $styleArray = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => ($rowNumber % 2 == 0) ? 'F3F3F3' : 'FFFFFF'],
            ],
        ];
        $sheet->getStyle('A' . $rowNumber . ':P' . $rowNumber)->applyFromArray($styleArray);

        $rowNumber++;
    }
}

// Set auto column width
foreach (range('A', 'P') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Tambahkan gaya untuk baris data
$dataStyle = [
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => '000000'],
        ],
    ],
];

$sheet->getStyle('A3:P' . ($rowNumber - 1))->applyFromArray($dataStyle);

// Menambahkan footer
$sheet->setCellValue('A' . $rowNumber, 'Total Transaksi:');
$sheet->setCellValue('B' . $rowNumber, '=COUNTA(A3:A' . ($rowNumber - 1) . ')');
$sheet->getStyle('A' . $rowNumber . ':B' . $rowNumber)->getFont()->setBold(true);

// Inisialisasi writer PDF
$writer = new Mpdf($spreadsheet);

// Tentukan header untuk output PDF
header('Content-Type: application/pdf');
header('Content-Disposition: attachment;filename="laporan-transaksi.pdf"');
header('Cache-Control: max-age=0');

// Tulis ke output
$writer->save('php://output');
exit;
