<?php
session_start();

//FORCAR HTTPS
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

/*====================================================
 ESTA LOGADO? DISPONIBILIZA ID PRO PROFILE.JS
======================================================*/
$user = !empty($_SESSION['user']) ? $_SESSION['user'] : null;
$fbToken = !empty($_SESSION['fb_token']) ? $_SESSION['fb_token'] : null;
$iniLogin = !empty($_SESSION['iniLogin']) ? $_SESSION['iniLogin'] : false;
?>
    <script>
        var iniLogin = false;
        var userIdLogado = false;

        //FORCAR URL LIMPA
        //history.pushState(null,"Kara4All | Pedidos de músicas e acompanhamento da fila online","https://kara4all.club/");
    </script>
<?php
if(!empty($user || $fbToken)){
    if($iniLogin){
        ?>
        <script>
            iniLogin = true;
        </script>
        <?php
        unset($_SESSION['iniLogin']);
    }
    ?>
    <script>
        userIdLogado = <?php echo $user['U_ID'] ?>;
    </script>
    <?php
}else{
    ?>
    <script>
        userIdLogado = false;
        iniLogin = false;
    </script>
<?php
}
/*====================================================
                         FB LOGIN
======================================================*/
//@ REMOVE OS WARNINGS
$success = @include_once './fb/fbconfig.php';
if (!$success) {
    include_once '../fb/fbconfig.php';
}

//USADO PARA PEGAR O TOKEN
$helper = $fb->getRedirectLoginHelper();

//PERMISSOES OPCIONAIS
$permissions = ['public_profile', 'email'];

//GERA O LINK DO LOGIN
$loginUrl = $helper->getLoginUrl('https://kara4all.club/fb/login-callback.php', $permissions);

$_SESSION['loginUrl'] = $loginUrl;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
          content="App web para realizar pedidos no karaokê do DJ Marcelo Nidal.">
    <meta name="author" content="Marcelo Nidal">
    <link rel="canonical" href="https://www.kara4all.com.br/">
    <meta name="title" content="Kara4All | Pedidos de músicas e acompanhamento da fila online">

    <title>Kara4All | Pedidos de músicas e acompanhamento da fila online</title>
    <link rel="shortcut icon" href="img/kara4all.ico">

    <!-- Global Stylesheets -->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="vendor/toastr/css/toastr.css">
    <link rel="stylesheet" href="vendor/datatables/css/jquery.dataTables.css">
    <link rel="stylesheet" href="vendor/jquery-ui/jquery-ui.min.css">
    <link rel="stylesheet" href="vendor/timepicki/css/timepicki.css">
</head>

<body id="page-top">
<!--====================================================
                         HEADER
======================================================-->
<header>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-collapse" id="mainNav" data-toggle="affix">
        <div class="container">
            <a href="index.php">
                <img src="img/kara4all.png" style="width: 30%;">
            </a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                    data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link smooth-scroll" href="#login" id="navLogin">Login</a></li>
                    <li class="nav-item"><a class="nav-link smooth-scroll" href="#profile" id="navProfile">Minha
                            Conta</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle smooth-scroll" href="#" id="navCategory"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categorias</a>
                        <div class="dropdown-menu dropdown-cust" aria-labelledby="navCategory">
                            <a class="dropdown-item" href="#nacional" id="nacional">Nacionais</a>
                            <a class="dropdown-item" href="#internacional" id="internacional">Internacionais</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<!--====================================================
                    LOGIN
======================================================-->
<section class="shop-form bg-gray" id="login">
</section>

<!--====================================================
                    REGISTER
======================================================-->
<section class="shop-form bg-gray" id="register">
</section>

<!--====================================================
                    PROFILE
======================================================-->
<section class="shop-form bg-gray" id="profile">
</section>

<!--====================================================
                         HOME
======================================================-->
<div id="back-to-top"></div>
<div id="homeBtn"></div>
<section id="home">
</section>

<!--====================================================
                       ORDER
======================================================-->
<section id="order">
</section>

<!--====================================================
                       CATEGORY
======================================================-->
<section id="category">
</section>

<!--====================================================
                      FOOTER
======================================================-->
<footer>
    <div id="footer-s1" class="footer-s1">
        <div class="footer">
            <div class="container">
                <div class="row">
                    <!-- Sobre -->
                    <div class="col-md-6" style="text-align: left; margin-right: 5%">
                        <div class="heading-footer"><h2>Sobre</h2></div>
                        <ul class="list-unstyled comp-desc-f">
                            <li><p>Kara4all é um webapp idealizado para facilitar a vida dos clientes mostrando as listas de músicas, a fila de pedidos, além de adicionar músicas na fila de pedidos.</p></li>
                        </ul>
                        <br>
                    </div>
                    <!-- Contato -->
                    <div class="col-md-4" style="text-align: left">
                        <div class="heading-footer"><h2>Entre em contato</h2></div>
                        <address class="address-details-f">
                            Email: <a href="mailto:contato@reviewsocial.com.br" class="">marcelonidaldj@gmail.com</a>
                        </address>
                        <br>
                    </div>
                    <!-- Sociais -->
                    <div class="col-md-6" style="text-align: left">
                        <div class="heading-footer"><h2>Redes Sociais</h2></div>
                        <ul class="list-unstyled comp-desc-f">
                            <li><img src="img/inst.png" style="width: 10%;margin-right: 5%"><a href="https://www.instagram.com/marcelonidaldj/">Instagram</a></li>
                            <br/>
                            <li><img src="img/fb.png" style="width: 10%;margin-right: 5%"><a href="https://www.facebook.com/djmarcelonidal/">Facebook</a></li>
                        </ul>
                        <br>
                    </div>
                </div>
            </div><!--/container -->
        </div>
    </div>

    <div id="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div id="footer-copyrights">
                        <p>Copyrights &copy; 2018 Todos os direitos reservados para Marcelo Nidal.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="#home" id="back-to-top" class="btn btn-sm btn-green btn-back-to-top smooth-scrolls hidden-sm hidden-xs"
       title="home" role="button">
        <i class="fa fa-angle-up"></i>
    </a>
</footer>

<div class="spinner"></div>
<!--Global JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/toastr/js/toastr.js"></script>
<script src="vendor/datatables/js/jquery.dataTables.js"></script>
<script src="vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="vendor/timepicki/js/timepicki.js"></script>

<!-- Plugin JavaScript -->
<script src="js/custom.js"></script>
<script src="home/home.js"></script>
<script src="profile/profile.js"></script>
<script src="category/category.js"></script>
</body>

</html>