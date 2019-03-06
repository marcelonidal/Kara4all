<?php
session_start();

$user = $_SESSION['user'];

?>

<div class="container">
    <div class="col-md-15">
        <div class="content-inner chart-cont">
            <button type="button" class="btn-white" aria-label="Close" id="closeProfile" style="float: right">
                <span aria-hidden="true">&times;</span>
            </button>
            <!-- CONTEUDO -->
            <div class="row mt-2" id="card-prof">
                <!-- SIDEBAR -->
                <div class="col-md-3">
                    <div class="card hovercard">
                        <div class="cardheader" style="background: white"></div>
                        <div class="info">
                            <div class="title">
                                <a><?php echo $user['U_NAME'] ?></a>
                            </div>
                            <div class="desc"><?php echo $user['U_EMAIL'] ?></div>
                            <hr>
                        </div>
                        <nav class="nav text-center prof-nav">
                            <ul class="list-unstyled">
                                <li><a href="#" id="logout">Logout</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- MENU TABS -->
                <div class="col-md-9">
                    <div class="card hovercard">
                        <div class="tab" role="tabpanel">
                            <ul class="nav nav-tabs" role="tablist">
                                <!-- MENU TAB1 -->
                                <li class="nav-item ">
                                    <a class="nav-link active" href="#info" role="tab" data-toggle="tab"><span><i
                                                class="ui-icon ui-icon-person"></i></span>Perfil</a>
                                </li>
                                <!-- MENU TAB2 -->
                                <li class="nav-item">
                                    <a class="nav-link" href="#references" role="tab" data-toggle="tab"><span><i
                                                class="ui-icon 	ui-icon-locked"></i></span>Configurações</a>
                                </li>
                            </ul>
                            <!-- CONTEUDO DAS TABS -->
                            <div class="tab-content tabs" style="height: 350px">
                                <!-- TAB1 -->
                                <div role="tabpanel" class="tab-pane fade show active" id="info">
                                    <div class="row mx-2">
                                        <div class="col-md-12">
                                            <h3 class="panel-title"><i class="fa fa-info"></i>Informações do
                                                Usuário
                                            </h3><br>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <strong class="mr-5"><i class="fa fa-envelope">
                                                        E-mail: </i></strong><?php echo $user['U_EMAIL'] ?>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <strong class="mr-5"><i class="fa fa-lock"> Senha: </i></strong>*****
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- TAB2 -->
                                <div role="tabpanel" class="tab-pane fade" id="references">
                                    <div class="row mx-2">
                                        <div class="col-md-12">
                                            <h3 class="panel-title"><i class="fa fa-edit"></i>Editar Informações
                                            </h3><br>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="example-lock-input"
                                                       class="col-form-label">Senha Atual</label>
                                                <div class="col-6">
                                                    <input class="form-control" type="password" value=""
                                                       id="old-lock-input"></input>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="example-lock-input"
                                                       class=" col-form-label">Nova Senha</label>
                                                <div class="col-6">
                                                    <input class="form-control" type="password" value=""
                                                           id="new-lock-input">
                                                </div>
                                                <button class="btn-white" style="height: 10%" id="resetSenha">Redefinir</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- FIM TABS -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
