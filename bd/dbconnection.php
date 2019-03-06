<?php

    // DB credentials.
	define('DB_HOST','');
	define('DB_USER','');
	define('DB_PASS','');
	define('DB_NAME','');
	# conectare la base de datos
    $con=@mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if(!$con){
        die("CONNECTION ERROR: ".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        die("CONNECTION SUCCESS: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }
?>