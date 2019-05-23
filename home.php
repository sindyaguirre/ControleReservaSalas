<?php
require_once 'classes/Funcoes.class.php';
require_once 'classes/Usuario.class.php';

$objFuncoes = new Funcoes();
$objUsuario = new Usuario();

if (isset($_POST['btCadastrar'])) {
    if ($objUsuario->queryInsert($_POST) == true) {

        header('location: /'.ROOT.'/home.php');
    } else {
        echo '<script type="text/javascript">alert("Erro em cadastrar");</script>';
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

            //botao de fechar formulário e abrir formulario

            $("#abrirCadastro").click(function (event) {
                window.location.href = "tarefa.php";
            });


            $("a.editar").click(function (event) {
                $("#fecharCadastro").show();
                $("#abrirCadastro").hide();
                $("#cadastro").show("slow");

            });
            $("a.excluir").click(function (event) {
                var apagar = confirm('Deseja realmente excluir este registro?');
            });
        });
    </script>
    <body>
        <!--navbar-->
        <nav class="navbar navbar-fixed-top navbar-inverse">
            <div class="navbar-inner">
                <div class="container">
                    <!--.btn-navbar estaclasse é usada como alteranador para o contepudo colapsave-->
                    <button class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="nav-collapse">
                        <ul class="nav">
                            <li><a href="sala.php">Salas</a></li>
                            <li><a href="reserva.php">Reservar Sala</a></li>
                            
                            <li><a href="usuario.php">Usuario</a></li>
                        </ul>

                    </div>

                </div>
            </div>
        </nav>
        <div><h1 class=""><small><?php echo TITLO; ?></small></h1></div>
        <p>
            <button type="button" class="btn btn-primary" name="reservar" id="reservar">Reservar Sala</button>
            <button type="button" class="btn btn-info" name="fecharCadastro" id="fecharCadastro">Fechar Formulário</button>
        </p>

        <div class="">
            <table id="tabelaReservas" class="table tablesorter table-striped tabelaReservas">
                <thead>
                    <tr>
                        <th scope="col">Sala</th>
                        <th scope="col">horarios</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Status</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($objUsuario->querySelect() as $rst) {
                        ?>
                        <tr>
                            <td scope='row' ><?php echo isset($rst['tarefa']) ? $objFuncoes->tratarCaracter($rst['tarefa'], 2) : ""; ?></td>
                            <td><?php echo isset($rst['projeto']) ? $objFuncoes->tratarCaracter($rst['projeto'], 2) : ""; ?></td>
                            <td><?php echo isset($rst['idTempoEstimado']) ? $objFuncoes->returnTempoEstimado(1, $rst['idTempoEstimado']) : ""; ?></td>
                            <td><?php echo isset($rst['idNivel']) ? $objFuncoes->returnNivel(1, $rst['idNivel']) : ""; ?></td>
                            <td><?php echo isset($rst['idStatus']) ? $objFuncoes->returnStatus(1, $rst['idStatus']) : ""; ?></td>
                            <td>
                                <div class="">
                                    <a class="editar" href="?acao=edit&tarf=<?= $objFuncoes->base64($rst['idTarefa'], 1) ?>" title="Editar dados"><img src="img/ico-editar.png" width="16" height="16" alt="Editar"></a>
                                    <a class="excluir" href="?acao=delet&tarf=<?= $objFuncoes->base64($rst['idTarefa'], 1) ?>" title="Excluir esse dado"><img src="img/ico-excluir.png" width="16" height="16" alt="Excluir"></a>
                                </div>
                            </td>
                        </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>