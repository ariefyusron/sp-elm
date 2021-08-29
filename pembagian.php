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

        <h2>Data Training Normalisasi</h2>
        <?php
            $data = mysqli_query($koneksi, "SELECT * FROM data_hari");
            $index = 0;
            $percent = 50;
            $percentResult = $percent / 100;
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
                            for($x = 1; $x <= $length; $x++){
                        ?>
                            <th>X<?= $x ?></th>
                        <?php        
                            }
                        ?>
                        <th>Target</th>
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
                        $targetList = array();
                        foreach($values as $value){
                            $sliceArrays = array_slice($values,$index + 1 , $length);
                            if(count($sliceArrays) === $length && $index < $lengthData){
                    ?>
                    <tr>
                        <td> <?php echo $index+1; ?></td>
                        <td> <?php echo ($value - $min) / ($max - $min); ?></td>
                        <?php 
                            $countLength = 1;
                            foreach ($sliceArrays as $sliceArray) {
                        ?>
                            <td> <?= ($sliceArray - $min) / ($max - $min); ?></td>
                        <?php 
                        if(count($sliceArrays) === $countLength) {
                            array_push($targetList, ($sliceArray - $min) / ($max - $min));
                        }

                        $countLength++;
                    }} ?>
                    </tr>
                    <?php
                    $index++;
                        }
                        $_SESSION['target_list'] = $targetList;
                        ?>                        
                </table>
                <?php
                }
                ?>

        <h2>Data Testing Normalisasi</h2>
        <?php
            $data = mysqli_query($koneksi, "SELECT * FROM data_hari");
            $index = 0;
            $percentResult = (100 - $percent) / 100;
            $targetTesting = array();
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
                            for($x = 1; $x <= $length; $x++){
                        ?>
                            <th>X<?= $x ?></th>
                        <?php        
                            }
                        ?>
                        <th>Target</th>
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
                        <td> <?php echo ($value - $min) / ($max - $min); ?></td>
                        <?php 
                            $indexSliceArrays = 0;
                            foreach ($sliceArrays as $sliceArray) {
                                $resultTargetTesting = ($sliceArray - $min) / ($max - $min);
                                if(count($sliceArrays) === ($indexSliceArrays + 1)){
                                    array_push($targetTesting, $resultTargetTesting);
                                }
                        ?>
                            <td> <?= $resultTargetTesting; ?></td>
                        <?php $indexSliceArrays++; }} ?>
                    </tr>
                    <?php
                    $index++;
                        } ?>                        
                </table>
                <?php
                }

                $_SESSION["target_testing"] = $targetTesting;
                ?>

        <script>
            console.log('targetTesting', JSON.parse("<?= json_encode($_SESSION["target_testing"]) ?>"))
        </script>
        
        <h2>Nilai Bobot</h2>
        <table>
            <tr>
                <th>No.</th>
                <?php
                    $no = 1;
                    for($i = 1; $i <= $hiddenLength;$i++){
                ?>
                    <th>w<?= $i ?></th>
                <?php        
                    }
                ?>
            </tr>
            <?php
                $valueBobot = array();
                for ($i=0; $i < $length; $i++) { 
                    $width = array();
                    for ($j=0; $j < $hiddenLength; $j++) { 
                        $bobot[$i][$j] = rand(0,90)/100;
                        $width[] = $bobot[$i][$j];
                    }
                    $valueBobot[] = $width;
                }
                $_SESSION['value_bobot'] = $valueBobot;

                foreach($valueBobot as $itemBobot){
            ?>
            <tr>
                <td><?= $no; ?></td>
                <?php
                    foreach($itemBobot as $item){
                ?>
                <td><?= $item; ?></td>
                <?php } ?>
            </tr>
            <?php $no++;} ?>
        </table>

        <h2>Nilai Bias</h2>
        <table>
            <tr>
                <th>No.</th>
                <?php
                    for($i = 1; $i <= $hiddenLength;$i++){
                ?>
                    <th>b<?= $i ?></th>
                <?php        
                    }
                ?>
            </tr>
            <?php
                $valueBias = array();
                for ($i=0; $i < $hiddenLength; $i++) { 
                    $bias[$i] = rand(0,90)/100;
                    $valueBias[] = $bias[$i];
                }
                $_SESSION['value_bias'] = $valueBias;
            ?>
            <tr>
                <td>1</td>
                <?php
                    foreach($valueBias as $itemB){
                ?>
                <td><?= $itemB; ?></td>
                <?php } ?>
            </tr>
        </table>
        </div>        
    </body>
</html>