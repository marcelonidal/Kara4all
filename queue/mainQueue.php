<?php
session_start();

$user = !empty($_SESSION['user']) ? $_SESSION['user'] : null;
$eventNow = !empty($_SESSION['eventoNow']) ? $_SESSION['eventoNow'] : null;
?>
<div class="container-fluid">
    <div class="table-wrapper">
        <div class="table-title">
            <button type="button" class="btn-white" aria-label="Close" id="closeQueue" title="Fechar" style="float: right">
                <span aria-hidden="true">&times;</span>
            </button>
            <br/>
            <div class="row">
                <div class="col-sm-6">
                    <a class="navbar-brand smooth-scroll" href="#" id="queueStart">
                        <h2>Lista de espera:</h2>
                    </a>
                </div>
            </div>
        </div>
        <div class="heading-border-light"></div>
        <div class='clearfix'></div>
        <!-- START -->
        <label id="queueInfo"></label>
        <div id="queueBody"></div>
        <!-- END -->
        </tbody>
        </table>
    </div>
    <div id="emptyQueue"></div>
    <div id="delFromQueue"></div>
        <?php
            if($user['U_EMAIL'] == 'marcelonidal@gmail.com'){
                ?>
                <script>
                    $('#delFromQueue').append('<button class="btn btn-white" id="btnClearQueue">Limpar Fila</button>');
                    $('#delFromQueue').append('<button class="btn btn-white" id="btnStopRefresh">Parar Refresh</button>');
                    $('#delFromQueue').append('<button class="btn btn-white" id="btnDelSong">Remove musica</button>');
                </script>
                <?php
            }
        ?>
    </div>
</div>
