<?php
?>
<div class="container">
    <div class="row">
        <div class="col-md-10 main-login main-center">
            <form class="form-horizontal" method="post" action="#" id="userReset">
                <div class="form-group">
                    <label for="username" class="cols-sm-2 control-label">Digite o seu email para recuperar a sua senha:</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-email fa" aria-hidden="true"></i></span>
                            <input type="email" class="form-control" name="useremail" id="user_email"
                                   placeholder="Digite o seu email"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <a href="#" class="btn btn-general btn-white text-center" name="btnReset">Redefinir</a>
                    <a href="#" class="btn btn-general btn-white text-center" name="btnCancel">Cancelar</a>
                </div>       
            </form>
                <div id="erroReset"></div>
        </div>
    </div>
</div>
