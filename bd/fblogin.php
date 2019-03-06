<?php
session_start();

//@ REMOVE OS WARNINGS
$success = @include_once './bd/dbconnection.php';
if (!$success) {
    include_once '../bd/dbconnection.php';
}

$fb_user_id = $_SESSION['fb_user_id'];
$fb_user_name = $_SESSION['fb_user_name'];
$fb_user_email = $_SESSION['fb_user_email'];

//====================================================
// BUSCA USER NO BANCO E ATUALIZA SE EXISTIR
//====================================================
$sql = 'SELECT * FROM USERS WHERE U_EMAIL LIKE ' . "'". $fb_user_email . "'";
$query = mysqli_query($con, $sql);

//ESTA NO BANCO
if ($query && $query->num_rows > 0) {
    $row = mysqli_fetch_array($query);
    //print_r($row);
    $userId = $row['U_ID'];
    $user = $row;
    $_SESSION['user'] = $user;

    //FAZ UPDATE
    $sql = 'UPDATE USERS SET FB_ID = ' . $fb_user_id . ' WHERE U_ID = ' . $userId;
    $query = mysqli_query($con, $sql);

    //chama
}else{
    //NAO ENCONTROU

    //====================================================
    // INSERE USER NO BD
    //====================================================
    $divisor = '@';
    $posicaoDivisor = strrpos($fb_user_email, $divisor);
    $username = substr($fb_user_email, 0, $posicaoDivisor);

    $pwd = null;
    $fb_id = $fb_user_id;
    $avatar_id = null;

    $sql = 'INSERT INTO USERS (U_NAME, U_EMAIL, U_USERNAME, U_PSW, FB_ID)
                VALUES(' . "'". $fb_user_name . "'". ','
        . "'". $fb_user_email . "'". ','
        . "'". $username . "'". ','
        . "'". md5($pwd) . "'". ','
        . "'". $fb_id . "'"
        . ')';

    $query = mysqli_query($con, $sql);

    //====================================================
    // BUSCA USER NO BANCO
    //====================================================
    $sql = 'SELECT * FROM USERS WHERE U_EMAIL LIKE ' . "'". $fb_user_email . "'";
    $query = mysqli_query($con, $sql);

//ESTA NO BANCO
    if ($query && $query->num_rows > 0) {
        $row = mysqli_fetch_array($query);
        //print_r($row);
        $userId = $row['U_ID'];
        $user = $row;
        $_SESSION['user'] = $user;
    }
}
$con->close();
?>