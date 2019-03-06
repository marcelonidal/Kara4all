<?php
session_start();

//@ REMOVE OS WARNINGS
$success = @include_once './bd/dbconnection.php';
if (!$success) {
    include_once '../bd/dbconnection.php';
}

$user = $_SESSION['user'];
$userId = $user['U_ID'] ? $user['U_ID'] : null;
$name = null;

$categoria = $user['U_EMAIL'] == 'marcelonidal@gmail.com'? $_REQUEST['categoria'] : $_SESSION['categoria'];
$tipoId = null;
$tipoArtist = null;
$tipoTitle = null;

$codigo = null;
$artist = null;
$title = null;

if($categoria == 'NAC'){
    $tipoId = 'N_ID';
    $tipoArtist = 'N_ARTIST';
    $tipoTitle = 'N_MUSIC';
}else{
    $tipoId = 'I_ID';
    $tipoArtist = 'I_ARTIST';
    $tipoTitle = 'I_MUSIC';
}

if($user['U_EMAIL'] == 'marcelonidal@gmail.com'){
    //parametros = {'convidado': x, 'categoria': y, 'cod_musica': z};
    $codigo = $_REQUEST['cod_musica'];
    $categoria = $_REQUEST['categoria'];
    $name = strtoupper($_REQUEST['convidado']);

    $sql = 'SELECT * FROM ' . $categoria . ' WHERE ' . $tipoId . ' = ' . $codigo;
    $query = mysqli_query($con, $sql);

    if($query != false){
        $row = mysqli_fetch_array($query);
        $artist = $row[$tipoArtist];
        $title = $row[$tipoTitle];
    }else{
        echo 'NOK';
    }
}else{
    //var parametros = {'id': x, 'title' : y, 'artist' : z};
    $name = $user['U_NAME'];
    $artist = $_REQUEST['artist'];
    $title = $_REQUEST['title'];
    $codigo = $_REQUEST['id'];
}

//====================================================
// PAPARACAO PARA REGRA DE PREFERENCIA
//====================================================
$tz = 'America/Sao_Paulo';
$timestamp = time();
$dt = new DateTime("now", new DateTimeZone($tz));
$dt->setTimestamp($timestamp);
$datetime = $dt->format('d/m/Y H:i:s');

$pedidos = 0;

$sql = "SELECT COUNT(Q_ORDERS) AS Q_ORDERS FROM QUEUE WHERE Q_NAME LIKE " . "'" . $name . "'" . " AND Q_DATE >= DATE_FORMAT(STR_TO_DATE(". "'" . $datetime . "'" . ", '%d/%m/%Y %T') - INTERVAL '8' HOUR, '%d/%m/%Y %T')";
$query = mysqli_query($con, $sql);

if($query != false){
    //+ DE UMA VEZ
    $pedidos = $rows = mysqli_fetch_array($query);
    $pedidos = $pedidos['Q_ORDERS'];
}

//====================================================
// INSERE FILA NO BD
//====================================================
$pedidos++;

$sql = 'INSERT INTO QUEUE (Q_USER_ID, Q_NAME, Q_COD_MUSIC, Q_MUSIC, Q_DATE, Q_ORDERS)
                VALUES(' . '"'. $userId . '"'. ','
    . '"'. $name . '"'. ','
    . '"'. $codigo . '"'. ','
    . '"'. trim($artist) . " - " . trim($title) . '"'. ','
    . '"'. $datetime . '"'. ','
    . '"' . $pedidos . '"'
    . ')';

$query = mysqli_query($con, $sql);

if($query == true){
    echo 'OK';
}else{
    echo 'NOK';
}
$con->close();
?>
