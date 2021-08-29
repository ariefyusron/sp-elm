<?php
    include "koneksi.php";
    session_start();
    $length = 4;
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
        
        <h2>Dataset</h2>
            <?php 
                $data = mysqli_query($koneksi, "SELECT * FROM data_hari");
                if (mysqli_num_rows($data) > 0) {?>
                    <table>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                        </tr>
                        
                        <?php
                            $dataArray = array();
                            while($d = mysqli_fetch_array($data)){
                            //print_r($d);
                        ?>
                        <tr>
                            <td> <?php echo $d['no']; ?></td>
                            <td> <?php echo $d['tanggal']; ?></td>
                            <td> <?php echo $d['jumlah']; ?></td>
                        </tr>
                        <?php
                            array_push($dataArray, (float)$d['jumlah']);
                            }
                            $_SESSION['data_max'] = max($dataArray);
                            $_SESSION['data_min'] = min($dataArray);
                            ?>
                        
                    </table>
                <?php
                }
                ?>

        <h2>Hasil Pembentukan Fitur</h2>
            <?php
                $data = mysqli_query($koneksi, "SELECT * FROM data_hari");
                $index = 0;
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
                            foreach($values as $value){
                                $sliceArrays = array_slice($values,$index + 1 , $length);
                                if(count($sliceArrays) === $length){
                        ?>
                        <tr>
                            <td> <?php echo $index+1; ?></td>
                            <td> <?php echo $value; ?></td>
                            <?php 
                                foreach ($sliceArrays as $sliceArray) {
                            ?>
                                <td> <?= $sliceArray; ?></td>
                            <?php }} ?>
                        </tr>
                        <?php
                        $index++;
                            } ?>                        
                    </table>
                    <?php
                    }
                    ?>

        <h2>Hasil Normalisasi Data</h2>
            <?php
                $data = mysqli_query($koneksi, "SELECT * FROM data_hari");
                $index = 0;
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
                            foreach($values as $value){
                                $sliceArrays = array_slice($values,$index + 1 , $length);
                                if(count($sliceArrays) === $length){
                        ?>
                        <tr>
                            <td> <?php echo $index+1; ?></td>
                            <td> <?php echo ($value - $min) / ($max - $min); ?></td>
                            <?php 
                                foreach ($sliceArrays as $sliceArray) {
                            ?>
                                <td> <?= ($sliceArray - $min) / ($max - $min); ?></td>
                            <?php }} ?>
                        </tr>
                        <?php
                        $index++;
                            } ?>                        
                    </table>
                    <?php
                    }
                    ?>
        </div>        
    </body>
</html>