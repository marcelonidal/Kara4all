<?php
session_start();

//@ REMOVE OS WARNINGS
$success = @include_once './bd/dbconnection.php';
if (!$success) {
    include_once '../bd/dbconnection.php';
}

//parametros = {'name': name, 'email': email, 'user': username, 'pwd': password};
$name = $_REQUEST['name'];
$email = $_REQUEST['email'];
$username = $_REQUEST['user'];
$pwd = $_REQUEST['pwd'];

$fb_id = null;
$fb_token = null;
$avatar_id = null;

//====================================================
// INSERE USER NO BD
//====================================================

$sql = 'INSERT INTO USERS (U_NAME, U_EMAIL, U_USERNAME, U_PSW, FB_ID)
                VALUES(' . "'". $name . "'". ','
                        . "'". $email . "'". ','
                        . "'". $username . "'". ','
                        . "'". md5($pwd) . "'". ','
                        . "'". $fb_id . "'"
                        . ')';

$query = mysqli_query($con, $sql);

if($query == 1){
    echo 'OK';
}else{
    echo 'NOK';
}
$con->close();
?>