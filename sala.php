<?php
require_once 'classes/Funcoes.class.php';
require_once 'classes/Sala.class.php';

$objFuncoes = new Funcoes();
$objSala = new Sala();

//verificando se esta logado
$objFuncoes->isLogado();

if (!isset($_SESSION['logado'])) {
    header('location: /' . ROOT . '/home.php');
}

if (isset($_POST['btCadastrar'])) {

    if ($objSala->queryInsert($_POST) == 'ok') {
        echo '<script type="text/javascript">alert("Cadastrado com sucesso!");</script>';

        header('location: /' . ROOT . '/sala.php');
    } else {
        echo '<script type="text/javascript">alert("Erro em cadastrar");</script>';
    }
}

if (isset($_POST['btAlterar'])) {
    //utilizar funcao default
    if ($objSala->queryUpdate($_POST) == 'ok') {
        header('location: ?acao=edit&idsala=' . $objFuncoes->base64($_POST['idsala'], 1));
    } else {
        echo '<script type="text/javascript">alert("Erro em alterar");</script>';
    }
}

if (isset($_GET['acao'])) {

    switch ($_GET['acao']) {

        case 'edit': $sala = $objSala->querySeleciona($_GET['idsala']);
            break;
        case 'delet':
            if ($objSala->queryDelete($_GET['idsala']) == 'ok') {
                header('location: /gerenciadorTarefas/sala');
            } else {
                echo '<script type="text/javascript">alert("Erro em deletar");</script>';
            }
            break;
    }
}
?>
<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">

        <title><?php echo TITLO; ?></title>

        <link href="css/estilo.css" rel="stylesheet" type="text/css" media="all">
        <!--Bootstrap--> 
        <link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" media="all">
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all">

        <!--jQuery (obrigatório para plugins JavaScript do Bootstrap)--> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <!--Inclui todos os plugins compilados (abaixo), ou inclua arquivos separadados se necessário--> 
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/bootstrap.min.js" crossorigin="anonymous"></script>
        <script src="js/jquery.mask.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>

    </head>

    <script>
        $(document).ready(function () {

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
                    </button>
                    <div class="nav-collapse">
                        <ul class="nav">
                            <li><a href="home.php"> | Reservar </a></li>
                            <li><a href="sala.php"> | Salas </a></li>
                            <?php echo $objFuncoes->isAdmin() ? '<li><a href="usuario.php"> | Usuarios </a></li>' : "" ?>
                            <li><a href="logout.php"> | Logout | </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div><h1 class=""><small>Cadastrar sala</small></h1></div>

        <div id="formulario">
            <form name="formCad" action="" method="post">

                <label>Sala <i>(Identificação da sala)</i>: </label><br>
                <input type="text" id="sala" name="sala" required="required" value="<?= isset($sala['sala']) ? ($sala['sala']) : ('') ?>"><br>

                <br>
                <label>Quantidade máx de pessoas: </label><br>
                <input type="text" id="qtdMaxAlunos" name="qtdMaxAlunos" required="required" value="<?= isset($sala['qtdMaxAlunos']) ? ($sala['qtdMaxAlunos']) : ('') ?>"><br>
 
                <input type="submit" name="<?= (isset($_GET['acao']) == 'edit') ? ('btAlterar') : ('btCadastrar') ?>" value="<?= (isset($_GET['acao']) == 'edit') ? ('Alterar') : ('Cadastrar') ?>">

                <!--CRIAR BOTÃO PARA LIMPAR FORMULARIO, E VOLTAR A TELA INICIAL-->

                <input type="hidden" name="idsala" value="<?= (isset($sala['idsala'])) ? ($objFuncoes->base64($sala['idsala'], 1)) : ('') ?>">
            </form>
        </div>
        <div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Sala</th>
                        <th scope="col">Quant Máx</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!$objSala->querySelect()) {
                        echo '<tr><td colspan=3 style="text-align: center;">Nenhum registro encontrado</td><tr>';
                    } else {
                        foreach ($objSala->querySelect() as $rst) {
                            ?>
                            <tr>
                                <td scope="row"><?php echo $objFuncoes->tratarCaracter($rst['idsala'], 2); ?></td>
                                <td><?php echo $rst['sala']; ?></td>
                                <td><?php echo $rst['qtdMaxAlunos']; ?></td>
                                <td>
                                    <div class="">
                                        <a class="editar" href="?acao=edit&idsala=<?= $objFuncoes->base64($rst['idsala'], 1) ?>" title="Editar dados"><img src="img/ico-editar.png" width="16" height="16" alt="Editar"></a>
                                        <a class="excluir" href="?acao=delet&idsala=<?= $objFuncoes->base64($rst['idsala'], 1) ?>" title="Excluir esse dado"><img src="img/ico-excluir.png" width="16" height="16" alt="Excluir"></a>
                                    </div>
                                </td>
                            </tr>
                        <?php }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
