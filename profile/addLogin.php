<?php
session_start();
$loginUrl = $_SESSION['loginUrl'];
?>

<div class="container">
    <div class="row">
        <div class="col-md-10 main-login main-center">
            <form class="form-horizontal" method="post" action="#" id="userLogin">
                <a href="<?php echo $loginUrl ?>">
                    <button type="button" class="btn btn-fb" style="float: right;" id="fbBtn">Facebook</button>
                </a>
                <br/>
                <br/>
                <div class="form-group">
                    <label for="username" class="cols-sm-2 control-label">Usuário</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="username" id="login_username"
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
                            <input type="password" class="form-control" name="password" id="login_password"
                                   placeholder="Digite sua senha"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <a href="#" class="btn btn-general btn-white text-center" name="btnLogin">Login</a>
                    <a href="#" class="btn btn-general btn-white text-center" name="btnCancel">Cancelar</a>
                    <hr>
                    <label for="register" class="cols-sm-2 control-label">Ainda não é cadastrado?</label>
                    <a href="#register" class="btn-link text-center" id="navRegister" style="color: #f47c48">Cadastre-se</a>
                    <label for="reset" class="cols-sm-2 control-label">Esqueceu sua senha?</label>
                    <a href="#reset" class="btn-link text-center" id="navReset" style="color: #f47c48">Clique aqui!</a>
                </div>
                
            </form>
                <div id="erroLogin"></div>
        </div>
    </div>
</div>