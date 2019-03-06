<?php
//@ REMOVE OS WARNINGS
$success = @include_once './bd/dbconnection.php';
if (!$success) {
    include_once '../bd/dbconnection.php';
}

$sql = "TRUNCATE TABLE QUEUE";
$query = mysqli_query($con, $sql);

if($query == true){
    echo 'OK';
}else{
    echo 'NOK';
}
$con->close();



