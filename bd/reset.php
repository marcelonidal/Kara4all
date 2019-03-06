<?php
session_start();

//@ REMOVE OS WARNINGS
$success = @include_once './bd/dbconnection.php';
if (!$success) {
    include_once '../bd/dbconnection.php';
}

$email = $_REQUEST['email'];

$sql = 'SELECT * FROM USERS WHERE U_EMAIL LIKE ' . "'" . $email . "'";
$query = mysqli_query($con, $sql);

if ($query && $query->num_rows > 0) {
    $row = mysqli_fetch_array($query);

    //CADASTRADO
    function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = []; //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    $password = randomPassword();

    //UPDATE NO USER
    $sql = 'UPDATE USERS SET U_PSW = ' . "'" . md5($password) . "'" . ' WHERE U_EMAIL = ' . "'" . $email . "'";
    $query = mysqli_query($con, $sql);

    $to = $email;
    $subject = 'Recuperação de senha';
    $message = 'Por favor, utilize a senha temporária para efetuar o login: ' . $password;
    $headers = 'From: contato@kara4all.club';

    mail($to, $subject, $message, $headers);

    echo 'OK';
}else{
    echo 'NOK';
}