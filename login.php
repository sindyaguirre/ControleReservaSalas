<?php
require_once 'classes/Funcoes.class.php';
require_once 'classes/Usuario.class.php';

$objFuncoes = new Funcoes();
$objUsuario = new Usuario();

if (isset($_POST['login'])) {
    
    if ($objUsuario->login($_POST) == true) {
       
        header('location: /' . ROOT . '/home.php');
    } else {
        if (isset($_SESSION['logado']) && $_SESSION['logado']==false) {
            echo '<script type="text/javascript">alert("'.$_SESSION['login_erro'].'");</script>';
        } else {
            echo '<script type="text/javascript">alert("Ops! Algo deu errado!");</script>';
        }
    }
}
?>
<!DOCTYPE HTML>
<html lang="pt-br">
    <!--head-->
    <head>

        <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
        <title>Gerenciador de salas</title>

        <link href="css/estilo.css" rel="stylesheet" type="text/css" media="all">
        <!--Bootstrap--> 
        <link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" media="all">
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all">
        <link rel="stylesheet" href="css/blue/style.css">

        <!--jQuery (obrigatório para plugins JavaScript do Bootstrap)--> 
        <script src="js/jquery.min.js"></script>

        <!--Inclui todos os plugins compilados (abaixo)--> 
        <script type="text/javascript" src="js/bootstrap.js"></script>
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js" crossorigin="anonymous"></script>

        <!-- jQuery e Tablesorter [ordenacao da table] -->
        <script src="js/jquery-latest.js"></script>
        <script src="js/jquery.tablesorter.min.js"></script>

        <!-- Meu script -->
        <script src="js/scripts.js"></script>
    </head>

    <script>
        $(document).ready(function () {


        });
    </script>
    <body>
        <div id="login">
            <form name="formLogin" id="formLogin" action="" method="post">
                <div class="container">
                    <div class="wrap">
                        <div><h1 class=""><small><?php echo TITLO; ?></small></h1></div>

                        <label>Email: </label>
                        <input type="mail" name="email" id="email" required="required" value="" ><br>

                        <label>Senha: </label>
                        <input type="password" name="senha" required="required"><br>

                        <input type="submit" name="login" value="Logar">
                    </div>
                </div>
            </form>

        </div>
    </body>
</html>
