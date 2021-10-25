<?php
if (($open = fopen($_FILES['fileexcel']['tmp_name'], "r")) !== FALSE) 
  {
  
    while (($data = fgetcsv($open, 1000, ",")) !== FALSE) 
    {        
      $array[] = $data; 
    }
  
    fclose($open);

    $queryDelete = "DELETE FROM data_hari";
    $hasilDelete = mysqli_query($koneksi, $queryDelete);

    foreach ($array as $keyItem=>$item) {
      if($keyItem > 0) {
        $tanggal = $item[0]; 
        $jumlah = $item[1];
        $pendapatan = $item[2];

        if ($tanggal != "" && $jumlah != "" && $pendapatan != "") {
          $query = "INSERT INTO data_hari VALUES (null, '$tanggal', $jumlah, $pendapatan)";
          $hasil = mysqli_query($koneksi, $query);
        }
      }
    }
  }
?>