<?php
// menggunakan class phpExcelReader
include "excel_reader2.php";

$target = basename($_FILES['fileexcel']['name']);
move_uploaded_file($_FILES['fileexcel']['tmp_name'], $target);

// beri permisi agar file xls dapat di baca
chmod($_FILES['fileexcel']['name'],0777);

$data = new Spreadsheet_Excel_Reader($_FILES['fileexcel']['tmp_name']);

$baris = $data->rowcount($sheet_index=0);

$berhasil = 0;

for ($i=2; $i<=$baris; $i++)
{
  $tanggal = $data->val($i, 1); 
  $jumlah = $data->val($i, 2);
  $pendapatan = $data->val($i, 3);

  if ($tanggal != "" && $jumlah != "" && $pendapatan != "") {
    $query = "INSERT INTO data_hari VALUES (null, '$tanggal', $jumlah, $pendapatan)";
    $hasil = mysqli_query($koneksi, $query);
    $berhasil++;
  }
}
unlink($_FILES['fileexcel']['name']);
header("location:data.php?berhasil=$berhasil");
?>