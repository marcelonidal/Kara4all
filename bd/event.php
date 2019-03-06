<?php
session_start();

//@ REMOVE OS WARNINGS
$success = @include_once './bd/dbconnection.php';
if (!$success) {
    include_once '../bd/dbconnection.php';
}

//parametros = {'data': data, 'local': local};
$data = $_REQUEST['data'];
$hora = $_REQUEST['hora'];
$local = $_REQUEST['local'];

$datetime = $data . ' ' . $hora;
$dt = DateTime::createFromFormat("d/m/Y G:i", $datetime);
$timestamp = $dt->getTimestamp();

$dt->setTimestamp($timestamp);
$datetime = $dt->format('d/m/Y H:i');

//====================================================
// INSERE EVENTO NO BD
//====================================================

$sql = 'INSERT INTO EVENTS (E_DATA, E_LOCAL)
                VALUES(' . "'". $datetime . "'". ','
    . "'". $local . "'"
    . ')';

$query = mysqli_query($con, $sql);

if($query == 1){
    echo 'OK';
}else{
    echo 'NOK';
}
$con->close();
?>