<?php
session_start();

$loginUrl = $_SESSION['loginUrl'];

$dirImg = '../img/flyers/';
$arrayFlyers = scandir($dirImg, 1);

$user = !empty($_SESSION['user']) ? $_SESSION['user'] : null;
$email = !empty($user['U_EMAIL']) ? $user['U_EMAIL'] : null;

$msg = null;
$eventoNow = false;
$flyer = null;

unset($_SESSION['eventoNow']);
unset($_SESSION['horaIni']);
unset($_SESSION['horaFim']);
unset($_SESSION['isToday']);

foreach ($arrayFlyers as $item) {
    $lastIndexOf = strpos($item, ".");
    $eventDate = substr($item, 0, $lastIndexOf);

    /*====================================================
    REGRA DE HORARIO
    ======================================================*/
    //@ REMOVE OS WARNINGS
    $success = @include_once './bd/dbconnection.php';
    if (!$success) {
        include_once '../bd/dbconnection.php';
    }

    //TROCAR FORMATACAO DA DATA
    $eDt = DateTime::createFromFormat("Ymd", $eventDate);
    $eTimestamp = $eDt->getTimestamp();
    $eDt->setTimestamp($eTimestamp);
    $eventDateF = $eDt->format('d/m/Y');

    $sql = "SELECT * FROM EVENTS WHERE E_DATA LIKE '" . $eventDateF . "%'";
    $query = mysqli_query($con, $sql);

    if ($query && $query->num_rows > 0) {
        $rows = mysqli_fetch_array($query);

        $horaIni = $rows['E_DATA'];
        $horaIni = substr($horaIni, 11, strlen($horaIni));

        //ADD + 8 HORAS DE EVENTO
        $timestamp = strtotime($horaIni) + 60 * 60 * 6;
        $horaFim = date('H:i', $timestamp);

        $_SESSION['horaIni'] = $horaIni;
        $_SESSION['horaFim'] = $horaFim;
    }

    $tz = 'America/Sao_Paulo';
    $timestamp = time();
    $dt = new DateTime("now", new DateTimeZone($tz));
    $dt->setTimestamp($timestamp);
    $datetime = $dt->format('Ymd');

    //HORA
    $horaNow = $dt->format('H:i');

    //ADD + 1 DIA AO EVENTO
    $dateLimit = date('Ymd', strtotime("+1 day", strtotime($eventDate)));

    //ACHOU FLYER
    if (strlen($item) > 3) {
        $flyer = $item;

        if ($eventDate == $datetime || $datetime == $dateLimit) {

            if ($eventDate == $datetime) {
                $msg = 'O evento de hoje é:';
                $_SESSION['isToday'] = true;
            } else {
                $_SESSION['isToday'] = false;
                if($horaNow > $horaFim){
                    $msg = 'O último evento foi:';
                }else{
                    $msg = 'O evento ainda não acabou!';
                }
            }
            $eventoNow = true;
            break;
        } else {
            if ($eventDate > $datetime) {

                $msg = 'O próximo evento é:';
                break;
            } else {
                $msg = 'O último evento foi:';
                break;
            }
            $eventoNow = false;
        }
    } else {
        $msg = 'Nenhum evento encontrado!';
        $urlFlyer = null;
        $eventoNow = false;
    }

}
$urlFlyer = './img/flyers/' . $flyer;
$_SESSION['eventoNow'] = $eventoNow;
?>

<div class="container">
    <div class="row">
        <div class="col-md-12 main-login main-center">
            <?php
            if ($email == "admin@mail.com") {
                ?>
                <script>
                    $('#homeBtn').html("");
                    $('#homeBtn').append('<button class="btn btn-white" id="btnAddQueueList">Acompanhar fila de músicas</button>');
                    $('#homeBtn').append('<button class="btn btn-white" id="btnAddEvent">Adicionar evento</button>');
                    $('#homeBtn').append('<button class="btn btn-white" id="btnAddSongList">Atualizar lista de músicas</button>');
                    //$('#homeBtn').append('<button class="btn btn-white" id="btnAddQueue">Adicionar música na fila</button>');
                </script>
            <?php
            }else if (($user && $_SESSION['eventoNow'] == true) && (($_SESSION['isToday'] == true && $horaNow >= $_SESSION['horaIni']) || ($_SESSION['isToday'] == false && $horaNow <= $_SESSION['horaFim']))){
            ?>
                <script>
                    $('#homeBtn').html("");
                    $('#homeBtn').append('<button class="btn btn-white" id="btnAddQueueList">Acompanhar fila de músicas</button>');
                </script>
                <?php
            }
            ?>
            <h1>Seja bem vindo!</h1>
            <h3><?php echo $msg ?></h3>
            <div>
                <img alt="" src="<?php echo $urlFlyer ?>" class="img-fluid">
            </div>
        </div>
    </div>
</div>
