<?php
session_start();
$loginUrl = $_SESSION['loginUrl'];
?>

<div class="container">
    <div class="row">
        <div class="col-md-10 main-login main-center">
            <form class="form-horizontal" method="post" action="#" id="registerForm">
                <a href="<?php echo $loginUrl ?>">
                    <button type="button" class="btn btn-fb" style="float: right;" id="fbBtn">Facebook</button>
                </a>
                <br/>
                <br/>
                <div class="form-group">
                    <label for="name" class="cols-sm-2 control-label">Seu Nome</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="name" id="register_name"
                                   placeholder="Digite o seu nome"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="cols-sm-2 control-label">Seu Email</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope fa"
                                                                   aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="email" id="register_email"
                                   placeholder="Digite o seu Email"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="username" class="cols-sm-2 control-label">Usuário</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="username" id="register_username"
                                   placeholder="Digite o seu usuário"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="cols-sm-2 control-label">Senha</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock fa-lg"
                                                                   aria-hidden="true"></i></span>
                            <input type="password" class="form-control" name="password" id="register_password"
                                   placeholder="Digite a sua senha"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm" class="cols-sm-2 control-label">Confirme a sua senha</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock fa-lg"
                                                                   aria-hidden="true"></i></span>
                            <input type="password" class="form-control" name="confirm" id="register_confirm"
                                   placeholder="Confirme a sua senha"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <a href="#" class="btn btn-general btn-white text-center" name="btnRegistrar">Registrar</a>
                    <a href="#" class="btn btn-general btn-white text-center" name="btnCancel">Cancelar</a>
                </div>
            </form>
            <div id="erroRegistro"></div>
        </div>
    </div>
</div>
