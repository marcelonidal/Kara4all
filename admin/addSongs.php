<?php

function ler_csv($dir, $dirListas, $categoria)
{
    $source = $dir . $dirListas . '/' . $categoria;
    $csvFile = file($source);

    if (strpos($categoria, 'nac_') === 0) {
        $data = [];
        foreach ($csvFile as $line) {
            $data[] = str_getcsv($line, ';', '"');
        }
        return $data;
    } else {
        $data = [];
        foreach ($csvFile as $line) {
            $data[] = str_getcsv($line, ';', "'");
        }
        return $data;
    }
}

$dir = '../admin/listas/';
$dirListas = null;
$arrayListas = scandir($dir, 1);
$isLista = null;

//pega o dir mais recente
foreach ($arrayListas as $item) {
    if (is_numeric($item)) {
        $dirListas = $item;
    }
}

$arraySongs = scandir($dir . $dirListas . '/', 1);
$arrayNac = [];
$arrayInt = [];

foreach ($arraySongs as $item) {
    if (strpos($item, 'nac_') === 0) {
        $arrayNac = ler_csv($dir, $dirListas, $item);
    } elseif (strpos($item, 'int_') === 0) {
        $arrayInt = ler_csv($dir, $dirListas, $item);
    }
}

//@ REMOVE OS WARNINGS
$success = @include_once './bd/dbconnection.php';
if (!$success) {
    include_once '../bd/dbconnection.php';
}

//====================================================
// INSERT NAS LISTAS
//====================================================
$title = null;
$artist = null;

if (!empty($arrayNac)) {
    $sql = 'TRUNCATE TABLE NAC';
    $query = mysqli_query($con, $sql);

    $sql = 'INSERT INTO NAC(N_ARTIST, N_MUSIC) VALUES';
    for ($i = 1; $i < sizeof($arrayNac); $i++) {
        ini_set('max_execution_time', 300);
        $title = $arrayNac[$i][0];
        $artist = $arrayNac[$i][1];

        $sql .= '('
            . '"' . $artist . '",'
            . '"' . $title . '"'
            . '),';

        if($i%100 == 0 && $i != 0){
            $sql = substr($sql, 0, strlen($sql)-1);
            $query = mysqli_query($con, $sql);
            $sql = 'INSERT INTO NAC(N_ARTIST, N_MUSIC) VALUES';
        }
    }
    $sql = substr($sql, 0, strlen($sql)-1);
    $query = mysqli_query($con, $sql);

    echo 'OK';
}else{
    echo 'NOK';
}

if (!empty($arrayInt)) {
    $sql = 'TRUNCATE TABLE INTER';
    $query = mysqli_query($con, $sql);

    $sql = 'INSERT INTO INTER(I_ARTIST, I_MUSIC) VALUES';
    for ($i = 1; $i < sizeof($arrayInt); $i++) {
        ini_set('max_execution_time', 300);
        $title = $arrayInt[$i][0];
        $artist = $arrayInt[$i][1];

        $sql .= '('
            . '"' . $artist . '",'
            . '"' . $title . '"'
            . '),';

        if($i%100 == 0 && $i != 0){
            $sql = substr($sql, 0, strlen($sql)-1);
            $query = mysqli_query($con, $sql);
            $sql = 'INSERT INTO INTER(I_ARTIST, I_MUSIC) VALUES';
        }
    }
    $sql = substr($sql, 0, strlen($sql)-1);
    $query = mysqli_query($con, $sql);

    echo 'OK';
}else{
    echo 'NOK';
}

//print_r($arrayNac[0]);
//print_r($arrayInt[0]);
