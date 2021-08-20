<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
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
                <div class="ca">
                    <a href="http://localhost/sp/bulan/juli.php" class="al">Per-Hari</a>
                </div>
                <div class="row">
                    <br><br><h1>DATA PENJUALAN</h1>
                    
                    <form method="post" enctype="multipart/form-data" action="proses.php">
                        <button><input name="fileexcel" type="file" required="required"></button>
                        <button name="upload" type="submit">Import</button><br><br>
                        <?php
                    include "koneksi.php";
                    $data = mysqli_query($koneksi, "SELECT * FROM data_bulan");
                    if (mysqli_num_rows($data) > 0) {?>
                    <table style="width:100%;border=1;">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Tahun</th>
                            <th>Bulan</th>
                            <th>Jumlah</th>
                            <th>Pendapatan</th>
                        </tr>
                        </thead>
                        
                        <?php
                            while($d = mysqli_fetch_array($data)){
                            //print_r($d);
                        ?>
                        <tbody>
                            <tr>
                            <td> <?php echo $d['no']; ?></td>
                            <td> <?php echo $d['tahun']; ?></td>
                            <td> <?php echo $d['bulan']; ?></td>
                            <td> <?php echo $d['jumlah']; ?></td>
                            <td> <?php echo $d['pendapatan']; ?></td>
                            </tr>
                        </tbody>
                        <?php
                            } ?>
                        
                        </table>
                        <?php
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
        <?php
    if(isset($_GET['berhasil'])){
        echo "".$_GET['berhasil']." Data berhasil di import.";
    }
    ?>
    </body>
</html>