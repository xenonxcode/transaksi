<?php
require 'vendor/autoload.php';
require 'koneksi.php';

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('PT. Sukses Kemilau');
$pdf->SetTitle('Laporan Laba Rugi');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();

// Definisi CSS untuk formatting
$style = <<<EOD
<style>
body {
    font-family: helvetica;
    font-size: 10pt;
}
h1, h2, h4 {
    text-align: center;
    margin-bottom: 5px;
}
.table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 20px;
}
th, td {
    border: 1px solid #000;
    padding: 8px;
    text-align: left;
}
th {
    background-color: #f0f0f0;
}
.total-row {
    background-color: #e0e0e0;
    font-weight: bold;
}
.center {
    text-align: center;
}
.right {
    text-align: right;
}
</style>
EOD;

// Menambahkan judul dan sub-judul laporan
$html = $style . '
<h1>Laporan Laba & Rugi</h1>
<h2>PT. Sukses Kemilau</h2>
<h4>Dari 01 April 2020 sampai 30 April 2020</h4>
';

// Membuat tabel
$html .= '<table class="table">
<thead>
    <tr>
        <th>Kategori</th>
        <th class="right">Jumlah (Rp)</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td>Total Pendapatan</td>
        <td class="right">' . number_format(675879000) . '</td>
    </tr>
    <tr class="total-row">
        <td>Total Harga Pokok Penjualan</td>
        <td class="right">' . number_format(97422136) . '</td>
    </tr>
    <tr>
        <td>Total Laba Kotor</td>
        <td class="right">' . number_format(578456864) . '</td>
    </tr>
    <tr>
        <td>Biaya Gaji</td>
        <td class="right">' . number_format(108951000) . '</td>
    </tr>
    <tr>
        <td>Biaya Asuransi</td>
        <td class="right">' . number_format(45900000) . '</td>
    </tr>
    <tr>
        <td>Total Beban Operasional</td>
        <td class="right">' . number_format(160499450) . '</td>
    </tr>
    <tr class="total-row">
        <td>Laba Bersih Operasional</td>
        <td class="right">' . number_format(417957414) . '</td>
    </tr>
</tbody>
</table>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('laporan_keuangan.pdf', 'I');
