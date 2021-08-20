<?php
$matrik = array(
    array(1,5,3),
    array(4,9,1),
    array(7,8,6)
);

$max = $matrik[0][0];
$min = $matrik[0][0];
$normalisasi[][] = 0;
//mencari data min-max
for ($i=0; $i < count($matrik); $i++) { 
    for ($j=0; $j < count($matrik[$i]); $j++) { 
        if ($matrik[$i][$j] > $max) {
            $max = $matrik[$i][$j];
        }elseif ($matrik[$i][$j] < $min) {
            $min = $matrik[$i][$j];
        }
    }
}
//echo 'Angka maksimal : '.$max.'<br>';
//echo 'Angka minimum : '.$min.'<br><br>';

//menghitung normalisasi dataset
echo 'Normalisasi : <br>';
for ($i=0; $i < count($matrik); $i++) { 
    for ($j=0; $j < count($matrik[$i]); $j++) { 
        $normalisasi[$i][$j] = ($matrik[$i][$j] - $min)/($max-$min);
        echo $normalisasi[$i][$j]."     ";
    }
    echo '<br>';
}
echo '<br>';

//mencari nilai bobot secara random
echo 'Nilai bobot : <br>';
for ($i=0; $i < 3; $i++) { 
    for ($j=0; $j < 2; $j++) { 
        $bobot[$i][$j] = rand(0,90)/100;
        echo $bobot[$i][$j].'   ';
    }
    echo '<br>';
}

//mencari nilai bias secara random
echo '<br> Nilai Bias : ';
for ($i=0; $i < 2; $i++) { 
    $bias[$i] = rand(0,90)/100;
    echo $bias[$i].'   ';
}
echo '<br>';

//menghitung Hinit
echo '<br><br>Hasil Hinit : <br>';
$hinit[][] = 0;
for ($i=0; $i < count($normalisasi); $i++) { 
    for ($j=0; $j < count($bias); $j++) { //hidden
        $sum = 0;
        for ($k=0; $k < count($bobot); $k++) { //fitur
            $sum += $normalisasi[$i][$k] * $bobot[$k][$j];
        }
        $hinit[$i][$j] = $sum + $bias[$j];
        echo $hinit[$i][$j].'       ';
    }
    echo '<br>';
}

//mencari fungsi aktivasi sigmoid biner
echo '<br><br>Hasil H(x) : <br>';
$sigmoid[][] = 0;
for ($i=0; $i < count($hinit); $i++) { 
    for ($j=0; $j < count($hinit[$i]); $j++) { 
        $sigmoid[$i][$j] = 1/(1+(exp(-$hinit[$i][$j])));
        echo $sigmoid[$i][$j]."     ";
    }
    echo '<br>';
}

//transpose matriks
echo '<br><br>Hasil HT : <br>';
$transpose[][] = 0;
for ($i=0; $i < count($sigmoid)-1; $i++) { 
    for ($j=0; $j < count($sigmoid); $j++) { 
        $transpose[$i][$j] = $sigmoid[$j][$i];
        echo $transpose[$i][$j].'   ';
    }
    echo '<br>';
}

//menghitung HT.H(x)
echo '<br><br>Hasil HT.H(x) : <br>';
$perkalian[][] = 0;
for ($i=0; $i < count($transpose); $i++) { 
    for ($j=0; $j < count($sigmoid[$i]); $j++) { 
        $temp = 0;
        for ($k=0; $k < count($transpose[$i]); $k++) { 
            $temp += $transpose[$i][$k] * $sigmoid[$k][$j];
        }
        $perkalian[$i][$j] = $temp;
        echo $perkalian[$i][$j].'       ';
    }
    echo '<br>';
}

//menghitung invers
echo '<br><br>Hasil invers matriks HT.H(x) : <br>';
$length = count($perkalian);
$doublelength = count($perkalian) * 2;
for ($i=0; $i < $length; $i++) { 
    for ($j=$length; $j < $doublelength; $j++) { 
        if ($i + $length == $j) {
            $perkalian[$i][$j] = 1.0;
        }else {
            $perkalian[$i][$j] = 0.0;
        }
        $perkalian[$i][$j - $length] = $perkalian[$i][$j - $length];
        //echo $perkalian[$i][$j].'   ';
    }
    //echo '<br>';
}

for ($j=0; $j < $length - 1; $j++) { 
    for ($i=$j + 1; $i < $length; $i++) { 
        if ($perkalian[$i][$j] != 0) {
            $hasil = $perkalian[$j][$j] / $perkalian[$i][$j];
            for ($k=$j; $k < $doublelength; $k++) { 
                $perkalian[$i][$k] *= $hasil;
                $perkalian[$i][$k] -= $perkalian[$j][$k];
                //echo $perkalian[$i][$k].'   ';
            }
            //echo '<br>';
        }
    }
}


for ($j=$length - 1; $j > 0; $j--) { 
    for ($i=$j - 1; $i >= 0; $i--) { 
        if ($perkalian[$i][$j] != 0) {
            $hasil = $perkalian[$j][$j] / $perkalian[$i][$j];
            for ($k=$i; $k < $doublelength; $k++) { 
                $perkalian[$i][$k] *= $hasil;
                $perkalian[$i][$k] -= $perkalian[$j][$k];
            }
        }
    }
}

for ($j=0; $j < $length; $j++) { 
    if ($perkalian[$j][$j] != 1) {
        $hasil = 1/$perkalian[$j][$j];
        for ($k=$j; $k < $doublelength; $k++) { 
            $perkalian[$j][$k] *= $hasil;
        }
    }
}

for ($i=0; $i < $length; $i++) { 
    for ($j=$length; $j < $doublelength; $j++) { 
        $perkalian[$i][$j-$length] = $perkalian[$i][$j];
        $invers[$i][$j] = $perkalian[$i][$j];
        echo $invers[$i][$j].'      ';
    }
    echo '<br>';
}

//menghitung H+
echo '<br><br>Hasil H+ : <br>';
$hplus[][] = 0;
for ($i=0; $i < count($transpose); $i++) { 
    for ($j=0; $j < count($transpose[$i]); $j++) { 
        $sum = 0;
        for ($k=0; $k < count($perkalian); $k++) { 
            $sum += $perkalian[$i][$k] * $transpose[$k][$j];
        }
        $hplus[$i][$j] = $sum;
        echo $hplus[$i][$j].'   ';
    }
    echo '<br>';
}

//menghitung output weight
echo '<br><br>Hasil B : <br>';
$B[] = 0;
$n = count($normalisasi[0]);
for ($i=0; $i < 2; $i++) { 
    $sum = 0;
    for ($j=0; $j < count($normalisasi); $j++) { 
        $sum += $hplus[$i][$j] * $normalisasi[$j][$n-1];//kenapa gitu?
    }
    $B[$i] = $sum;
    echo $B[$i].'   ';
}
echo '<br>';

$matrik2 = array(
    array(1,5,3),
    array(8,7,1)
);

$max2 = $matrik2[0][0];
$min2 = $matrik2[0][0];
$normalisasi[][] = 0;
//mencari data min-max
for ($i=0; $i < count($matrik2); $i++) { 
    for ($j=0; $j < count($matrik2[$i]); $j++) { 
        if ($matrik2[$i][$j] > $max2) {
            $max2 = $matrik2[$i][$j];
        }elseif ($matrik2[$i][$j] < $min2) {
            $min2 = $matrik2[$i][$j];
        }
    }
}
//echo 'Angka maksimal : '.$max2.'<br>';
//echo 'Angka minimum : '.$min2.'<br><br>';

//menghitung normalisasi dataset
echo '<br><br>Hasil Normalisasi Data Testing : <br>';
for ($i=0; $i < count($matrik2); $i++) { 
    for ($j=0; $j < count($matrik2[$i]); $j++) { 
        $normalisasi2[$i][$j] = ($matrik2[$i][$j] - $min)/($max-$min);
        echo $normalisasi2[$i][$j]."     ";
    }
    echo '<br>';
}

//menghitung hinit
echo '<br><br>Hasil Hinit Data Testing : <br>';
$hinit2[][] = 0;
for ($i=0; $i < count($normalisasi2); $i++) { 
    for ($j=0; $j < count($bias); $j++) { //hidden
        $sum = 0;
        for ($k=0; $k < count($bobot); $k++) { //fitur
            $sum += $normalisasi2[$i][$k] * $bobot[$k][$j];
        }
        $hinit2[$i][$j] = $sum + $bias[$j];
        echo $hinit2[$i][$j].'       ';
    }
    echo '<br>';
}

//mencari fungsi aktivasi sigmoid biner
echo '<br><br>Hasil H(x) Data Testing : <br>';
$sigmoid2[][] = 0;
for ($i=0; $i < count($hinit2); $i++) { 
    for ($j=0; $j < count($hinit2[$i]); $j++) { 
        $sigmoid2[$i][$j] = 1/(1+(exp(-$hinit2[$i][$j])));
        echo $sigmoid2[$i][$j]."     ";
    }
    echo '<br>';
}

//menghitung output prediksi
echo '<br><br>Hasil Output Prediksi (Y) : <br>';
for ($i=0; $i < count($sigmoid2); $i++) { 
    $sum = 0;
    for ($j=0; $j < count($sigmoid2[$i]); $j++) { 
        $sum += $sigmoid2[$i][$j] * $B[$j];
    }
    $Y[$i] = $sum;
    echo $Y[$i].'   ';
}
echo '<br>';
?>