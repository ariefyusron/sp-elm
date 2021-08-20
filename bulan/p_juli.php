<?php
include "../excel_reader2.php";
include "../koneksi.php";
        $target = basename($_FILES['filejuli']['name']);
        move_uploaded_file($_FILES['filejuli']['tmp_name'], $target);
        
        chmod($_FILES['filejuli']['name'],0777);

        $data = new Spreadsheet_Excel_Reader($_FILES['filejuli']['tmp_name']);

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
        unlink($_FILES['filejuli']['name']);
        header("location:juli.php?berhasil=$berhasil");
?>