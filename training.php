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

        <h2>Hasil Hinit</h2>
        <?php
            $data = mysqli_query($koneksi, "SELECT * FROM data_hari");
            $index = 0;
            $percent = 50;
            $percentResult = $percent / 100;

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
                            if(count($sliceArrays) === $length && $index < $lengthData){
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
            $data = mysqli_query($koneksi, "SELECT * FROM data_hari");
            $index = 0;
            $percent = 50;
            $percentResult = $percent / 100;

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
                            <th>H(x)<?= $x ?></th>
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
                            if(count($sliceArrays) === $length && $index < $lengthData){
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
                                $resultAktivasi = 0;
                                $indexListData = 0;
                                foreach($valueBobot as $itemValueBobot) {
                                    $result += $listData[$indexListData] * $itemValueBobot[$iColumn];
                                    $indexListData++;
                                }
                                $result += $valueBias[$iColumn];
                                
                                echo $resultAktivasi = 1 / (1+(exp(-$result)));

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

        <h2>Hasil Transpose</h2>
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
                $dataTranspose=array();
                ?>
                <table>
                    <tr>
                        <th>Simbol</th>
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
                            if(count($sliceArrays) === $length && $index < $lengthData){
                    ?>
                    <th><?php echo $index+1; ?></th>
                    <?php } ?>
                    <?php
                    $index++;
                        } ?>  
                    </tr>

                    <?php
                        for($x = 1; $x <= $hiddenLength; $x++){
                            $dataTranspose[$x-1] = array();
                    ?>
                        <tr>
                            <th>H(x)<?= $x ?></th>
                            <?php
                            $index = 0;
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
                                    if(count($sliceArrays) === $length && $index < $lengthData){
                            ?>
                            <td><?php 
                                $listData = array(($value - $min) / ($max - $min));
                                foreach ($sliceArrays as $sliceArray) {
                                    $listData[] = ($sliceArray - $min) / ($max - $min);
                                }
                                $result = 0;
                                $resultAktivasi = 0;
                                $indexListData = 0;
                                foreach($valueBobot as $itemValueBobot) {
                                    $result += $listData[$indexListData] * $itemValueBobot[$x-1];
                                    $indexListData++;
                                }
                                $result += $valueBias[$x-1];
                                $finalResult = $resultAktivasi = 1 / (1+(exp(-$result)));
                                array_push($dataTranspose[$x-1], $finalResult);
                                
                                echo $finalResult;

                            ?></td>
                            <?php } ?>
                    <?php
                    $index++;
                        } ?>  
                        </tr>
                    <?php        
                        }
                    ?>                      
                </table>
                <?php
                }
                ?>

        <h2>Hasil Invers OBE</h2>
        <?php
            $resultObe = array();
            $indexA = 0;
            foreach ($dataTranspose as $dataTransposeA) {
                $resultObe[$indexA] = array();
                $indexB = 0;
                $resultB = array();
                foreach ($dataTranspose as $dataTransposeB) {
                    
                    $resultValueB = 0;
                    $indexC = 0;
                    foreach ($dataTransposeB as $dataTransposeC) {
                        $resultValueB = $resultValueB + ($dataTransposeA[$indexC] * $dataTransposeC);
                        $indexC++;
                    }
                    array_push($resultB,$resultValueB);    
                    $indexB++;
                }
                $resultObe[$indexA] = $resultB;
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

        <?php
            function getAdj ($dataArray) {
                $manipulateResultObe = $dataArray;
                $det = 0;
                if(count($dataArray) > 2) {
                    $indexManipulateResultObe = 0;
                    foreach($dataArray as $keyManipulateResultObe) {
                        $manipulateResultObe[$indexManipulateResultObe] = array_merge($keyManipulateResultObe,array_slice($keyManipulateResultObe, 0,count($keyManipulateResultObe) - 1));
                        $indexManipulateResultObe++;
                    }
                    $kolomBasic = 0;
                    foreach($dataArray as $itemResultObe) {
                        $baris = 0;
                        $kolom = $kolomBasic;
                        $resultPositive = 1;
                        foreach($dataArray as $subItemResultObe) {
                            $resultPositive = $resultPositive * $manipulateResultObe[$baris][$kolom];
                            $baris++;
                            $kolom++;
                        }
                        $det = $det + $resultPositive;
                        $kolomBasic++;
                    }

                    $kolomBasic = 0;
                    foreach($dataArray as $itemResultObe) {
                        $baris = count($dataArray) - 1;
                        $kolom = $kolomBasic;
                        $resultPositive = 1;
                        foreach($dataArray as $subItemResultObe) {
                            $resultPositive = $resultPositive * $manipulateResultObe[$baris][$kolom];
                            $baris--;
                            $kolom++;
                        }
                        $det = $det - $resultPositive;
                        $kolomBasic++;
                    }
                } else {;
                    $det = ($dataArray[0][0] * $dataArray[1][1]) - ($dataArray[0][1] * $dataArray[1][0]);
                }

                return $det;
            }

            function manipulateArray ($dataArray, $indexBaris, $indexKolom) {
                $res = array();
                foreach ($dataArray as $key => $item) {
                    if($key !== $indexBaris) {
                        $resSub = array();
                        foreach($item as $keySub => $subItem) {
                            if($keySub !== $indexKolom) {
                                array_push($resSub, $subItem);
                            }
                        }
                        array_push($res, $resSub);
                    }
                }

                return $res;
            }

            $detA = 0;
            foreach($resultObe as $keyItem=>$itemInversObe) {
                $plusOrMin = $keyItem % 2 === 0 ? 1 : -1;
                $detA = $detA + ($plusOrMin * (getAdj(manipulateArray($resultObe, $keyItem, 0))));
            }

            $inversObe = $resultObe;
            $plusOrMin = -1;
            foreach($resultObe as $keyItem=>$itemInversObe) {
                foreach($itemInversObe as $keySubItem=>$subItemInversObe) {
                    $plusOrMin = $plusOrMin === -1 ? 1 : -1;
                    $matrix = manipulateArray($resultObe, $keyItem, $keySubItem);
                    $inversObe[$keyItem][$keySubItem] = $plusOrMin * (1 / $detA * getAdj($matrix));
                }
            }
        ?>

                    <script>
                        console.log('tes', JSON.parse('<?= json_encode($inversObe) ?>'))
                        console.log('tes', '<?= $detA ?>')
                    </script>
<br>
        <table>
            <?php
                foreach($inversObe as $keyObe) {
            ?>
                <tr>
                    <?php foreach($keyObe as $itemObe) { ?>
                        <td><?= $itemObe ?></td>
                    <?php
                        }
                    ?>
                </tr>
            <?php
                $indexKeyObe++; 
                }
            ?>
        </table>

        <br/>
        <br/>

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
                        <th>Simbol</th>
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
                            if(count($sliceArrays) === $length && $index < $lengthData){
                    ?>
                    <th><?php echo $index+1; ?></th>
                    <?php } ?>
                    <?php
                    $index++;
                        } ?>  
                    </tr>

                    <?php
                        $indexTranspose = 0;
                        foreach($dataTranspose as $itemDataTranspose) {
                    ?>
                        <tr>
                            <th>H(x)<?= $indexTranspose+1 ?></th>
                            <?php
                                $indexKeyData = 0;
                                foreach($itemDataTranspose as $keyDataTrasnpose) {
                            ?>
                                <td>
                                    <?php
                                        $result = 0;
                                        $indexSub = 0;
                                        foreach($dataTranspose as $subDataTranspose) {
                                            $result = $result + $subDataTranspose[$indexKeyData] * $inversObe[$indexTranspose][$indexSub];

                                            $indexSub++;
                                        }

                                        echo $result;
                                    ?>
                                </td>
                            <?php
                            $indexKeyData++;
                                }
                            ?>
                        </tr>
                    <?php
                            $indexTranspose++;
                        }
                    ?>
                </table>
                <?php
                }
                ?>

        <h2>Hasil Output Weight</h2>
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
                    <?php
                        $indexTranspose = 0;
                        $resultWeight = array();
                        foreach($dataTranspose as $itemDataTranspose) {
                    ?>
                        <tr>
                            <?php
                                $indexKeyData = 0;
                                $resultFinal = 0;
                                foreach($itemDataTranspose as $keyDataTrasnpose) {
                                    $result = 0;
                                    $indexSub = 0;
                                    foreach($dataTranspose as $subDataTranspose) {
                                        $result = $result + $subDataTranspose[$indexKeyData] * $inversObe[$indexTranspose][$indexSub];

                                        $indexSub++;
                                    }

                                    $resultFinal = $resultFinal + ($result * $_SESSION['target_list'][$indexKeyData]);
                                    $indexKeyData++;
                                }
                                array_push($resultWeight, $resultFinal);
                            ?>
                            <td><?= $resultFinal ?></td>
                        </tr>
                    <?php
                            $indexTranspose++;
                        }
                    ?>
                </table>
                <?php
                }

                $_SESSION['result_weight'] = $resultWeight;
                ?>

        </div>        
    </body>
</html>