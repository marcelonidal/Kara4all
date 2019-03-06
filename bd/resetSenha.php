<?php
session_start();

//@ REMOVE OS WARNINGS
$success = @include_once './bd/dbconnection.php';
if (!$success) {
    include_once '../bd/dbconnection.php';
}

$oldPsw = $_REQUEST['old'];
$newPsw = $_REQUEST['new'];
$user = $_SESSION['user'];
$userCurrentPsw = $user['U_PSW'];
$userId = $user['U_ID'];

if(md5($oldPsw) != $userCurrentPsw){
    $con->close();
    echo 'NOK';
}else{
    $newPsw = md5($newPsw);
    $sql = 'UPDATE USERS SET U_PSW = ' . "'" . $newPsw . "'" . ' WHERE U_ID = ' . $userId;
    //echo $sql;
    $query = mysqli_query($con, $sql);
    //var_dump($query);
    $con->close();
    echo 'OK';
}