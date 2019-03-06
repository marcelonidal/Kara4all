//====================================================
// USERIDLOGADO VEM DA SESSION PHP
//====================================================
var userId = userIdLogado > 0 ? userIdLogado : null;
if (userId > 0) {
    $('#navLogin').attr("id", "navLogout").attr("href", "#").text('Sair');
}

//====================================================
// INILOGIN VEM DA SESSION PHP
//====================================================
$(document).ready(function () {
    var iniFbLogin = iniLogin.length > 0 ? iniLogin : false;
    if (iniFbLogin) {
        iniFbLogin = false;
    }
});

//====================================================
// HIDE ALL
//====================================================
function hideAll() {
    $('#login').hide();
    $('#register').hide();
    $('#profile').hide();
    $('#admin').hide();
}

//====================================================
// LOGIN
//====================================================

$("#mainNav").on('click', '#navLogin', function () {
    insereLogin();
});

function insereLogin() {
    $.ajax({
        type: "POST",
        url: './profile/addLogin.php',
        dataType: "html",
        success: function (data) {
            $('#profile').html("");
            $('#register').html("");

            $('#home').hide();
            $('#homeBtn').hide();
            $('#category').hide();
            $('#category').html("");

            $('#login').html(data);
            $('#login').show();
            scrollToElement($('#login'));
        },
        error: function (xhr) {
            toastr.error('Status: ' + xhr.statusText + ' Resp: ' + xhr.responseText);
        }
    })
}

$("#login").on('click', 'a[name=btnLogin]', function () {
    $('a[name=btnLogin]').off();
    login();
});

$("#login").on('click', 'a[name=btnCancel]', function () {
    $('#login').html("");
    $('#login').hide();

    $('#home').show();
    $('#homeBtn').show();
    $('#category').show();
});

function login() {
    var username = $("#login_username").val();
    var password = $("#login_password").val();

    if (!username || !password) {
        toastr.error('Favor preencher os campos vazios!');
    } else {
        var parametros = {'user': username, 'pwd': password};

        $.ajax({
            type: "POST",
            url: './bd/login.php',
            data: parametros,
            dataType: "html",
            beforeSend: function () {
                $('body').toggleClass('loading');
            },
            success: function (data) {
                $('body').removeClass('loading');
                //console.log('INFO= ' + data);
                if (data > 0) {
                    userId = data;
                    $('#navLogin').attr("id", "navLogout").attr("href", "#").text('Sair');
                    $('#login').html("");
                    $('#logar').html("");
                    $('#category').html("");
                    hideAll();

                    $('#home').show();
                    $('#homeBtn').show();
                    $('#category').show();

                    scrollToElement($('#home'));
                    toastr.info('Login realizado com sucesso!');

                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else {
                    toastr.error('Usuário não encontrado!');
                }
            },
            error: function (xhr) {
                toastr.error('Status: ' + xhr.statusText + ' Resp: ' + xhr.responseText);
            }
        })
    }
}

//====================================================
// REGISTER
//====================================================

$("#login").on('click', '#navRegister', function () {
    $('#login').html("");
    $('#profile').html("");

    $('#home').hide();
    $('#homeBtn').hide();
    $('#category').hide();
    $('#category').html("");

    insereRegistro();
});

function insereRegistro() {

    $.ajax({
        type: "POST",
        url: './profile/addRegister.php',
        dataType: "html",
        success: function (data) {
            $('#register').html(data);
            hideAll();
            $('#register').show();
            scrollToElement($('#register'));
        },
        error: function (xhr) {
            toastr.error('Status: ' + xhr.statusText + ' Resp: ' + xhr.responseText);
        }
    })
}

$("#register").on('click', 'a[name=btnRegistrar]', function () {
    registrar();
});

$("#register").on('click', 'a[name=btnCancel]', function () {
    $('#register').html("");

    $('#home').show();
    $('#homeBtn').show();
    $('#category').show();

    hideAll();
});

function registrar() {
    var name = $("#register_name").val();
    var email = $("#register_email").val();
    var username = $("#register_username").val();
    var password = $("#register_password").val();
    var confirm = $("#register_confirm").val();
    var parametros = null;

    if (!name || !email || !username || !password || !confirm) {
        toastr.error('Favor preencher os campos vazios!');
        return;
    } else if (password == confirm) {
        parametros = {'name': name, 'email': email, 'user': username, 'pwd': password};
    } else {
        toastr.error('Senhas não conferem!');
        return;
    }

    $.ajax({
        type: "POST",
        url: './bd/register.php',
        data: parametros,
        dataType: "html",
        beforeSend: function () {
            $('body').toggleClass('loading');
        },
        success: function (data) {
            $('body').removeClass('loading');
            //console.log("DATA=" + data);
            if (data == 'OK') {
                toastr.success('Cadastro realizado com sucesso!');
                $('#register').html("");
                $('#home').show();
                $('#homeBtn').show();
                $('#category').show();
            } else {
                toastr.error('Usuário ou email já cadastrados!');
            }
        },
        error: function (xhr) {
            toastr.error('Status: ' + xhr.statusText + ' Resp: ' + xhr.responseText);
        }
    })
}

//====================================================
// RESET SENHA
//====================================================

$("#login").on('click', '#navReset', function () {
    $('#login').html("");
    $('#profile').html("");
    insereReset();
});

function insereReset() {

    $.ajax({
        type: "POST",
        url: './profile/addReset.php',
        dataType: "html",
        success: function (data) {
            $('#register').html(data);
            hideAll();
            $('#register').show();
            scrollToElement($('#register'));
        },
        error: function (xhr) {
            toastr.error('Status: ' + xhr.statusText + ' Resp: ' + xhr.responseText);
        }
    })
}

$("#register").on('click', 'a[name=btnReset]', function () {
    redefinir();
});

$("#register").on('click', 'a[name=btnCancel]', function () {
    $('#register').html("");
});

function redefinir() {
    var email = $("#user_email").val();
    var parametros = null;

    if (!email) {
        toastr.error('Favor preencher os campos vazios!');
        return;
    } else {
        parametros = {'email': email};
    }

    $.ajax({
        type: "POST",
        url: './bd/reset.php',
        data: parametros,
        dataType: "html",
        beforeSend: function () {
            $('body').toggleClass('loading');
        },
        success: function (data) {
            $('body').removeClass('loading');
            //console.log("DATA=" + data);
            if (data == 'OK') {
                toastr.info('Email enviado para a sua conta!');
                $('#register').html("");
                hideAll();
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                toastr.error('Email não cadastrado!');
            }
        },
        error: function (xhr) {
            toastr.error('Status: ' + xhr.statusText + ' Resp: ' + xhr.responseText);
        }
    })
}

//====================================================
// PROFILE
//====================================================
$("#profile").on('click', '#closeProfile', function () {
    $('#profile').html("");

    $('#home').show();
    $('#homeBtn').show();
    $('#category').show();

    hideAll();
});

$("#mainNav").on('click', '#navProfile', function () {
    $('#login').html("");
    $('#register').html("");

    $('#home').hide();
    $('#homeBtn').hide();
    $('#category').hide();
    $('#category').html("");

    isLogedIn();
});

function isLogedIn() {
    //console.log('USER_ID=' + userId);
    if (userId > 0) {
        insereProfile()
    } else {
        insereLogin();
    }
}

function insereProfile() {
    $.ajax({
        type: 'POST',
        url: './profile/addProfile.php',
        dataType: "html",
        beforeSend: function () {
            $('body').toggleClass('loading');
        },
        success: function (data) {
            $('body').removeClass('loading');
            if (data == 'NOK' || data == 'SOAP') {
                toastr.error('Serviço de avatar indisponível no momento!');
            } else {
                $('#profile').html(data);
                hideAll();
                $('#profile').show();
                scrollToElement($('#profile'));
            }
        },
        error: function (xhr) {
            toastr.error('Status: ' + xhr.statusText + ' Resp: ' + xhr.responseText);
        }
    })
}

//====================================================
// RESET SENHA
//====================================================
$("#profile").on('click', '#resetSenha', function () {
    resetSenha();
});

function resetSenha() {

    var oldPsw = $("#old-lock-input").val();
    var newPsw = $("#new-lock-input").val();

    if (!oldPsw || !newPsw) {
        toastr.error('Favor preencher os campos vazios!');
        return;
    } else if (oldPsw == newPsw) {
        toastr.error('Favor utilizar senha diferente da anterior!');
        return;
    } else {
        parametros = {'old': oldPsw, 'new': newPsw};
        //console.log(parametros);

        $.ajax({
            type: 'POST',
            url: './bd/resetSenha.php',
            data: parametros,
            dataType: "html",
            beforeSend: function () {
                $('body').toggleClass('loading');
            },
            success: function (data) {
                //console.log('RESP= ' + data.toString());
                $('body').removeClass('loading');
                if (data == 'OK') {
                    toastr.success('Reset de senha realizado com sucesso!');
                    hideAll();
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else {
                    toastr.error('A senha antiga não confere com a cadastrada!');
                }
                scrollToElement($('#profile'));
            },
            error: function (xhr) {
                toastr.error('Status: ' + xhr.statusText + ' Resp: ' + xhr.responseText);
            }
        })
    }
}

//====================================================
// LOGOUT
//====================================================
$("#mainNav").on('click', '#navLogout', function () {
    doLogout();
});

$("#profile").on('click', '#logout', function () {
    doLogout();
});

function doLogout() {
    $.ajax({
        type: 'POST',
        url: './profile/logout.php',
        dataType: "html",
        success: function (data) {
            $('#profile').html("");
            userId = null;
            hideAll();
            $('#navLogout').attr("id", "navLogin").attr("href", "#login").text('Login');
            scrollToElement($('#home'));
            toastr.info('Logout realizado com sucesso!');

            setTimeout(function () {
                location.reload();
            }, 1000);
        },
        error: function (xhr) {
            toastr.error('Status: ' + xhr.statusText + ' Resp: ' + xhr.responseText);
        }
    })
}