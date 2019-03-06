<?php
session_start();

//@ REMOVE OS WARNINGS
$success = @include_once './bd/dbconnection.php';
if (!$success) {
    include_once '../bd/dbconnection.php';
}

$sql = "SELECT Q_ID FROM QUEUE";
$query = mysqli_query($con, $sql);
$song = null;

if($query != false){
    $song = mysqli_fetch_array($query);
    $song = $song['Q_ID'];
}

//====================================================
// REMOCAO DA FILA
//====================================================

$sql = "DELETE FROM QUEUE WHERE Q_ID = " . $song;
$query = mysqli_query($con, $sql);

if($query == true){
    echo 'OK';
}else{
    echo 'NOK';
}
$con->close();