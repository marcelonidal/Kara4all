<?php

session_start();

//@ REMOVE OS WARNINGS
$success = @include_once './bd/dbconnection.php';
if (!$success) {
    include_once '../bd/dbconnection.php';
}

$user = $_REQUEST['user'];
$pwd = $_REQUEST['pwd'];

//====================================================
// BUSCA USER POR NOME E SENHA
//====================================================

$sql = 'SELECT * FROM USERS WHERE U_USERNAME LIKE ' . "'". $user . "'". ' && U_PSW LIKE '. "'". md5($pwd) . "'";

$query = mysqli_query($con, $sql);
//var_dump($query);

//ESTA NO BANCO
if ($query && $query->num_rows > 0) {
    $row = mysqli_fetch_array($query);
    //print_r($row);

    $userId = $row['U_ID'];
    $user = $row;

    $_SESSION['user'] = $user;

    echo $userId;

}else{
    echo 'NOK';
}
$con->close();
?>