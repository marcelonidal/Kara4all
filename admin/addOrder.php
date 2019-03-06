<?php
session_start();
$user = !empty($_SESSION['user']) ? $_SESSION['user'] : null;

$id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : null;
$title = !empty($_REQUEST['title']) ? $_REQUEST['title'] : null;
$artist = !empty($_REQUEST['artist']) ? $_REQUEST['artist'] : null;
$category = !empty($_REQUEST['category']) ? $_REQUEST['category'] : null;

$eventNow = !empty($_SESSION['eventoNow']) ? $_SESSION['eventoNow'] : null;

//REGRA DE HORARIO
$tz = 'America/Sao_Paulo';
$timestamp = time();
$dt = new DateTime("now", new DateTimeZone($tz));
$dt->setTimestamp($timestamp);
$horaNow = $dt->format('H:i');

$currentOrder = [];
array_push($currentOrder, $id, $title, $artist, $category);

if ($user && !empty($id && $title && $artist)) {
    if ($user['U_EMAIL'] == 'marcelonidal@gmail.com') {
        echo json_encode($currentOrder);
    } else if ($eventNow == true) {
        if (($_SESSION['isToday'] == true && $horaNow >= $_SESSION['horaIni']) || ($_SESSION['isToday'] == false && $horaNow <= $_SESSION['horaFim'])) {
            ?>
            <div id="addOrderModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form name="create_order" id="create_order">
                            <div class="modal-header">
                                <h4 class="modal-title">Adicionar a lista de espera:</h4>
                                <button type="button" class="btn-white" data-dismiss="modal" aria-hidden="true">
                                    &times;
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Música:</label>
                                    <label id="musicOrder"><?php echo $artist . ' - ' . $title ?></label>
                                </div>
                            </div>
                            <div class="modal-footer" style="background-color: #fff">
                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar"
                                       id="cancelOrder">
                                <input type="button" class="btn btn-white" value="Adicionar" id="insertOrder">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        } else {
            if($_SESSION['isToday']){
                $warning = "O evento ainda não começou!";
            }else{
                $warning = "O evento já encerrou!";
            }
            ?>
            <div id="addOrderModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form name="create_order" id="create_order">
                            <div class="modal-header">
                                <h4 class="modal-title">Opa!</h4>
                                <button type="button" class="btn-white" data-dismiss="modal" aria-hidden="true">
                                    &times;
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="login" class="cols-sm-2 control-label"><?php echo $warning ?></label>
                                </div>
                            </div>
                            <div class="modal-footer" style="background-color: #fff">
                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar"
                                       id="cancelOrder">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        ?>
        <div id="addOrderModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form name="create_order" id="create_order">
                        <div class="modal-header">
                            <h4 class="modal-title">Opa!</h4>
                            <button type="button" class="btn-white" data-dismiss="modal" aria-hidden="true">&times;
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="login" class="cols-sm-2 control-label">Sem evento no dia de hoje!</label>
                            </div>
                        </div>
                        <div class="modal-footer" style="background-color: #fff">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar"
                                   id="cancelOrder">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    ?>
    <div id="addOrderModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form name="create_order" id="create_order">
                    <div class="modal-header">
                        <h4 class="modal-title">Opa!</h4>
                        <button type="button" class="btn-white" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="login" class="cols-sm-2 control-label">Faça o login!</label>
                            <a href="#login" class="btn-link text-center" id="navLogin" style="color: #f47c48">Clique
                                aqui!</a>
                            <br>
                            <label for="register" class="cols-sm-2 control-label">Ainda não é cadastrado?</label>
                            <a href="#register" class="btn-link text-center" id="navRegister" style="color: #f47c48">Cadastre-se</a>
                        </div>
                    </div>
                    <div class="modal-footer" style="background-color: #fff">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar"
                               id="cancelOrder">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}
?>
