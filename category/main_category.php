<?php
session_start();
$category = !empty($_REQUEST['category']) ? $_REQUEST['category'] : null;
unset($_SESSION['categoria']);
$_SESSION['categoria'] = $category;

$eventNow = !empty($_SESSION['eventoNow']) ? $_SESSION['eventoNow'] : null;

$tz = 'America/Sao_Paulo';
$timestamp = time();
$dt = new DateTime("now", new DateTimeZone($tz));
$dt->setTimestamp($timestamp);
$horaNow = $dt->format('H:i');

$user = !empty($_SESSION['user']) ? $_SESSION['user'] : null;
?>
<div class="container-fluid">
    <div class="table-wrapper">
        <div class="table-title">
            <?php
            if(($user && $eventNow == true) && (($_SESSION['isToday'] == true && $horaNow >= $_SESSION['horaIni']) || ($_SESSION['isToday'] == false && $horaNow <= $_SESSION['horaFim']))){
                ?>
                <button class="btn btn-white" id="btnAddQueueList2">Acompanhar file de músicas</button>
                <?php
            }
            ?>
            <button type="button" class="btn-white" aria-label="Close" id="closeCategory" title="Fechar" style="float: right">
                <span aria-hidden="true">&times;</span>
            </button>
            <br/>
            <div class="row">
                <div class="col-sm-6">
                    <a class="navbar-brand smooth-scroll" href="#" id="categoryStart">
                        <h2><?php
                            if ($category == 'NAC') {
                                echo 'Lista Nacional';
                            } else {
                                echo 'Lista Internacional';
                            }
                            ?></h2>
                    </a>
                </div>
            </div>
        </div>
        <div class="heading-border-light"></div>
        <div class='clearfix'></div>
        <!-- START -->
        <div id="categoryBody"></div>
        <!-- END -->
        </tbody>
        </table>
    </div>
    <div id="logarCategory" style="margin-left: 65%"></div>
</div>
