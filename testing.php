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
            <div class="container">
                <form action="">
                    <div class="row">
                        <div class="col-25">
                            <label for="data">Data Load</label>
                        </div>
                        <div class="col-75">
                            <input type="upload" value="Upload">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fitur">Jumlah Fitur</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="fitur" name="jumlahfitur" placeholder="Wajib Diisi..">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="hiden">Jumlah Hiddden Neuron</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="hiden" name="jumlahhiden" placeholder="Wajib Diisi..">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="persen">Persentase Pembagian Data</label>
                        </div>
                        <div class="col-75">
                            <select id="persen" name="persendata">
                                <option value="data1">Data Training 50% : Data Testing 50%</option>
                                <option value="data2">Data Training 80% : Data Testing 20%</option>
                                <option value="data3">Data Training 90% : Data Testing 10%</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <br><input type="submit" value="Submit">
                    </div>
                </form>
            </div>

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

            if (mysqli_num_rows($data) > 0) {
                $values = array();
                while($d = mysqli_fetch_array($data)){
                    $values[] = $d['jumlah'];
                }
                $max = max($values);
                $min = min($values);
                $fungsiAktivasi = array();
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
                                $hinit = 0;
                                $result = 0;
                                $indexListData = 0;
                                foreach($valueBobot as $itemValueBobot) {
                                    $hinit += $listData[$indexListData] * $itemValueBobot[$iColumn];
                                    $indexListData++;
                                }
                                $hinit += $valueBias[$iColumn];
                                
                                echo $result = 1 / (1+(exp(-$hinit)));
                                
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

        <h2>Hasil Output Prediksi</h2>
        <?php
            $resultOprediksi = array();
            $indexA = 0;
            foreach ($fungsiAktivasi as $fungsiAktivasiA) {
                $resultOprediksi[$indexA] = array();
                $indexB = 0;
                $resultB = array();
                foreach ($fungsiAktivasiA as $fungsiAktivasiB) {
                    
                    $resultValueB = 0;
                    $indexC = 0;
                    foreach ($fungsiAktivasiB as $fungsiAktivasiC) {
                        $resultValueB = $resultValueB + ($fungsiAktivasiA[$indexC] * $fungsiAktivasiC);
                        $indexC++;
                    }
                    array_push($resultB,$resultValueB);    
                    $indexB++;
                }
                $resultOprediksi[$indexA] = $resultB;
                $indexA++;
            }
        ?>
        <table>
            <?php
                $indexKeyObe = 0; 
                foreach($resultObe as $keyObe) {
                $indexItemObe = 0;
            ?>
                <tr>
                    <?php foreach($keyObe as $itemObe) { ?>
                        <td><?= $itemObe ?></td>
                    <?php
                        $indexItemObe++;
                        }
                    ?>
                </tr>
            <?php
                $indexKeyObe++; 
                }
            ?>
        </table>

        <h2>Hasil Denormalisasi Data</h2>
        <table>
                        <tr>
                            <th>No</th>
                            <?php
                                for($x = 1; $x <= $length; $x++){
                            ?>
                                <th>X<?= $x ?></th>
                            <?php        
                                }
                            ?>
                            <th>Target</th>
                        </tr>
                        <?php
                            foreach($values as $value){
                                $sliceArrays = array_slice($values,$index + 1 , $length);
                                if(count($sliceArrays) === $length){
                        ?>
                        <tr>
                            <td> <?php echo $index+1; ?></td>
                            <td> <?php echo $value($max - $min) + $min; ?></td>
                            <?php 
                                foreach ($sliceArrays as $sliceArray) {
                            ?>
                                <td> <?= $value($max - $min) + $min; ?></td>
                            <?php }} ?>
                        </tr>
                        <?php
                        $index++;
                            } ?>                        
                    </table>
        </div>        
    </body>

        <script>
            console.log('weight', JSON.parse("<?= json_encode($_SESSION['result_weight']) ?>"))
        </script>
</html>