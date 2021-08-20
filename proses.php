<?php
// menggunakan class phpExcelReader
include "excel_reader2.php";
 
// koneksi ke mysql
include "koneksi.php";

$target = basename($_FILES['fileexcel']['name']);
move_uploaded_file($_FILES['fileexcel']['tmp_name'], $target);
 
// beri permisi agar file xls dapat di baca
chmod($_FILES['fileexcel']['name'],0777);

$data = new Spreadsheet_Excel_Reader($_FILES['fileexcel']['tmp_name']);

$baris = $data->rowcount($sheet_index=0);
 
$sukses = 0;

for ($i=2; $i<=$baris; $i++)
{
  $tahun = $data->val($i, 1); 
  $bulan = $data->val($i, 2);
  $jumlah = $data->val($i, 3);
  $pendapatan = $data->val($i, 4);

  if ($tahun != "" && $bulan != "" && $jumlah != "" && $pendapatan != "") {
    $query = "INSERT INTO data_bulan VALUES ('', '$tahun', '$bulan', '$jumlah', '$pendapatan')";
    $hasil = mysqli_query($koneksi, $query);
    $sukses++;
  }
}
unlink($_FILES['fileexcel']['name']);
header("location:nata.php?berhasil=$berhasil");
?>