<?php 
    include "koneksi.php";
    $length = 4;
    session_start();
    $hiddenLength = 3; 
?>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <style>
            body{
                background: white;
            }
        </style>
    </head>
    <body>
        <input type="checkbox" id="check">
        <label for="check">
            <i class="fas fa-bars" id="btn"></i>
            <i class="fas fa-times" id="cancel"></i>
        </label>
        
        <div class="sidebar">
            <header><img src="img/janjijiwa.png" style="weidth:100px;height:100px;padding:3;margin-left:2px;"></header>
            <ul>
                <li><a href="http://localhost/sp/home.php"><i class="fas fa-home"></i>Home</a></li>
                <li><a href="http://localhost/sp/data.php"><i class="fas fa-filter"></i>Sistem Prediksi</a></li>
                <li><a href="http://localhost/sp/nata.php"><i class="fas fa-file"></i>Data Penjualan</a></li>
            </ul>
        </div>

        <div style="margin-left:10%;padding:80px 10px;">
            <?php include "form.php" ?>

            <div class="btn-group">
                <a href="http://localhost/sp/data.php" class="button">Data</a>
                <a href="http://localhost/sp/pembagian.php" class="button">Pembagian Data</a>
                <a href="http://localhost/sp/training.php" class="button">Proses Training</a>
                <a href="http://localhost/sp/testing.php" class="button">Proses Testing</a>
                <a href="http://localhost/sp/evaluasi.php" class="button">Hasil Evaluasi</a>
            </div>

            <script>
                console.log('outputPrediksi', JSON.parse("<?= json_encode($_SESSION["output_prediksi"]) ?>"))
                console.log('targetTesting', JSON.parse("<?= json_encode($_SESSION["target_testing"]) ?>"))
            </script>

            <h2>Nilai MAPE</h2>
        <table>
            <tr>
                <th>Nilai Error</th>
            </tr>
            <?php
                $target = $_SESSION["target_testing"];
                $output = $_SESSION["output_prediksi"];
                $index = 0;
                $nilaiMape = array();

                foreach ($target as $Itarget) {
                    array_push($nilaiMape, ($Itarget - $output[$index]) / 2);
                    $index++;
                }

                foreach ($nilaiMape as $InilaiMape) {
            ?>
                    <tr>
                        <td><?= $InilaiMape ?>%</td>
                    </tr>
            <?php
                }
            ?>
        </table>

        <h2>Nilai Akurasi</h2>
        <table>
            <tr>
                <th>Akurasi</th>
            </tr>
            <?php
                foreach ($nilaiMape as $InilaiMape) {
            ?>
                    <tr>
                        <td><?= 100 - $InilaiMape ?>%</td>
                    </tr>
            <?php
                }
            ?>
        </table>
        </div>        
    </body>
</html>