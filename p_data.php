<?php
// menggunakan class phpExcelReader
include "excel_reader2.php";
 
// koneksi ke mysql
include "koneksi.php";

$target = basename($_FILES['filedata']['name']);
move_uploaded_file($_FILES['filedata']['tmp_name'], $target);
 
// beri permisi agar file xls dapat di baca
chmod($_FILES['filedata']['name'],0777);

$data = new Spreadsheet_Excel_Reader($_FILES['filedata']['tmp_name']);

$baris = $data->rowcount($sheet_index=0);
 
$sukses = 0;

for ($i=2; $i<=$baris; $i++)
{
  $tanggal = $data->val($i, 1); 
  $jumlah = $data->val($i, 2);
  $pendapatan = $data->val($i, 3);

  if ($tanggal != "" && $jumlah != "" && $pendapatan != "") {
    $query = "INSERT INTO data_hari VALUES ('', '$tanggal', '$jumlah', '$pendapatan')";
    $hasil = mysqli_query($koneksi, $query);
    $sukses++;
  }
}
unlink($_FILES['filedata']['name']);
header("location:data.php?berhasil=$berhasil");
?>