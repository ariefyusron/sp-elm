<?php
	$namahost= "localhost";
	$namauser="root";
	$password="";
	$namadatabase="data_penjualan";

	$koneksi=mysqli_connect($namahost,$namauser,$password,$namadatabase);
	$koneksi->set_charset('utf8mb4');

	if(!$koneksi){
		die("Koneksi gagal: ".mysqli_connect_error());
	}
?>