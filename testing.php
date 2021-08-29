<?php session_start(); ?>
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

        <h2>Hasil Hinit</h2>
        <?php
            include "koneksi.php";
            $data = mysqli_query($koneksi, "SELECT * FROM data_hari");
            $index = 0;
            $length = 4;
            $percent = 50;
            $percentResult = (100 - $percent) / 100;
            $hiddenLength = 3;

            $valueBobot = $_SESSION['value_bobot'];

            $valueBias = $_SESSION['value_bias'];

            if (mysqli_num_rows($data) > 0) {
                $values = array();
                while($d = mysqli_fetch_array($data)){
                    $values[] = $d['jumlah'];
                }
                $max = max($values);
                $min = min($values);
                ?>
                <table>
                    <tr>
                        <th>No</th>
                        <?php
                            for($x = 1; $x <= $hiddenLength; $x++){
                        ?>
                            <th>Hinit<?= $x ?></th>
                        <?php        
                            }
                        ?>
                    </tr>
                    <?php
                        $no = 0;
                        foreach($values as $value){
                            $sliceArrays = array_slice($values,$index + 1 , $length);
                            if(count($sliceArrays) === $length){
                                $no++;
                            }
                            $index++;
                        }
                        $index = 0;
                        $lengthData = ceil($no * $percentResult);
                        foreach($values as $value){
                            $sliceArrays = array_slice($values,$index + 1 , $length);
                            if(count($sliceArrays) === $length && $index >= $lengthData){
                    ?>
                    <tr>
                        <td> <?php echo $index+1; ?></td>
                        <?php
                            for($iColumn = 0; $iColumn < $hiddenLength; $iColumn++){
                        ?>
                            <td><?php 
                                $listData = array(($value - $min) / ($max - $min));
                                foreach ($sliceArrays as $sliceArray) {
                                    $listData[] = ($sliceArray - $min) / ($max - $min);
                                }
                                $result = 0;
                                $indexListData = 0;
                                foreach($valueBobot as $itemValueBobot) {
                                    $result += $listData[$indexListData] * $itemValueBobot[$iColumn];
                                    $indexListData++;
                                }
                                echo $result + $valueBias[$iColumn];
                            ?></td>
                        <?php } ?>

                        <?php } ?>
                    </tr>
                    <?php
                    $index++;
                        } ?>                        
                </table>
                <?php
                }
                ?>

        <h2>Hasil Fungsi Aktivasi</h2>
        <?php
            include "koneksi.php";
            $data = mysqli_query($koneksi, "SELECT * FROM data_hari");
            $index = 0;

            $valueBobot = $_SESSION['value_bobot'];

            $valueBias = $_SESSION['value_bias'];

            $fungsiAktivasi = array();

            if (mysqli_num_rows($data) > 0) {
                $values = array();
                while($d = mysqli_fetch_array($data)){
                    $values[] = $d['jumlah'];
                }
                $max = max($values);
                $min = min($values);
                ?>
                <table>
                    <tr>
                        <th>No</th>
                        <?php
                            for($x = 1; $x <= $hiddenLength; $x++){
                        ?>
                            <th>Hinit<?= $x ?></th>
                        <?php        
                            }
                        ?>
                    </tr>
                    <?php
                        $no = 0;
                        foreach($values as $value){
                            $sliceArrays = array_slice($values,$index + 1 , $length);
                            if(count($sliceArrays) === $length){
                                $no++;
                            }
                            $index++;
                        }
                        $index = 0;
                        $lengthData = ceil($no * $percentResult);
                        foreach($values as $value){
                            $sliceArrays = array_slice($values,$index + 1 , $length);
                            if(count($sliceArrays) === $length && $index >= $lengthData){
                    ?>
                    <tr>
                        <td> <?php echo $index+1; ?></td>
                        <?php
                            $subFungsiAktivasi = array();
                            for($iColumn = 0; $iColumn < $hiddenLength; $iColumn++){
                        ?>
                            <td><?php 
                                $listData = array(($value - $min) / ($max - $min));
                                foreach ($sliceArrays as $sliceArray) {
                                    $listData[] = ($sliceArray - $min) / ($max - $min);
                                }
                                $hinit = 0;
                                $result = 0;
                                $indexListData = 0;
                                foreach($valueBobot as $itemValueBobot) {
                                    $hinit += $listData[$indexListData] * $itemValueBobot[$iColumn];
                                    $indexListData++;
                                }
                                $hinit += $valueBias[$iColumn];

                                array_push($subFungsiAktivasi, $result = 1 / (1+(exp(-$hinit))));
                                
                                echo $result = 1 / (1+(exp(-$hinit)));
                                
                            ?></td>
                        <?php }
                            array_push($fungsiAktivasi,$subFungsiAktivasi);
                        ?>

                        <?php } ?>
                    </tr>
                    <?php
                    $index++;
                        } ?>                        
                </table>
                <?php
                }
                ?>

        <script>
            console.log('fungsiAktivasi', JSON.parse("<?= json_encode($fungsiAktivasi) ?>"))
        </script>

        <h2>Hasil Output Prediksi</h2>
        <?php
            $resultOprediksi = array();
            $resultWeight = $_SESSION['result_weight'];
            foreach ($fungsiAktivasi as $fungsiAktivasiA) {
                $resulSubCountPrediksi = 0;
                $indexA = 0;
                foreach ($fungsiAktivasiA as $fungsiAktivasiB) {
                    $resulSubCountPrediksi += ($resultWeight[$indexA] * $fungsiAktivasiB);
                    $indexA++;
                }
                array_push($resultOprediksi,$resulSubCountPrediksi);
            }
            $_SESSION["output_prediksi"] = $resultOprediksi;
        ?>

        <table>
            <?php
                foreach($resultOprediksi as $resultOprediksiA) {
            ?>
                <tr>
                    <td><?= $resultOprediksiA ?></td>
                </tr>
            <?php
                }
            ?>
        </table>

        <h2>Hasil Denormalisasi Data</h2>
        <?php
            $resultDenormalisasi = array();
            $dataMax = $_SESSION['data_max'];
            $dataMin = $_SESSION['data_min'];
            foreach ($resultOprediksi as $resultOprediksiA) {
                array_push($resultDenormalisasi, ($resultOprediksiA * ($dataMax - $dataMin)) + $dataMin);
            }
        ?>

        <table>
            <?php
                foreach($resultDenormalisasi as $resultDenormalisasiA) {
            ?>
                <tr>
                    <td><?= $resultDenormalisasiA ?></td>
                </tr>
            <?php
                }
            ?>
        </table>
        </div>        
    </body>

        <script>
                        console.log('denor', JSON.parse("<?= json_encode($resultDenormalisasi) ?>"))
            console.log('weight', JSON.parse("<?= json_encode($_SESSION['result_weight']) ?>"))
            console.log('max', <?= $_SESSION['data_max'] ?>)
            console.log('min', <?= $_SESSION['data_min'] ?>)
        </script>
</html>