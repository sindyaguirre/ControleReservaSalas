<?php
require_once 'classes/Funcoes.class.php';
require_once 'classes/Usuario.class.php';

$objFuncoes = new Funcoes();
$objUsuario = new Usuario();

$objFuncoes->isLogado();

if (!isset($_SESSION['logado'])) {
    header('location: /' . ROOT . '/home.php');
}

if (isset($_POST['btCadastrar'])) {
    if ($objUsuario->queryInsert($_POST) == 'ok') {

        header('location: /' . ROOT . '/usuario.php');
    } else {
        echo '<script type="text/javascript">alert("Erro em cadastrar");</script>';
    }
}

if (isset($_POST['btAlterar'])) {
    //utilizar funcao default
    if ($objUsuario->queryUpdate($_POST) == 'ok') {
        header('location: ?acao=edit&func=' . $objFuncoes->base64($_POST['func'], 1));
    } else {
        echo '<script type="text/javascript">alert("Erro em alterar");</script>';
    }
}

if (isset($_GET['acao'])) {
    switch ($_GET['acao']) {
        case 'edit': $sala = $objUsuario->querySeleciona($_GET['func']);
            break;
        case 'delet':
            if ($objUsuario->queryDelete($_GET['func']) == 'ok') {
                header('location: /gerenciadorTarefas/usuario');
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

        })
    </script>
    <body>
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
                            <li><a href="reserva.php">Reservar</a></li>
                            <li><a href="sala.php">Salas</a></li>
                            <?php echo $objFuncoes->isAdmin() ? '<li><a href="usuario.php">Usuarios</a></li>' : "" ?>

                            <li><a href="logout.php">Logout</a></li>
                        </ul>

                    </div>

                </div>
            </div>
        </nav>

        <div><h1 class=""><small>Cadastrar usuário</small></h1></div>

        <div id="formulario">
            <form name="formCad" action="" method="post">
                <label>Nome: </label><br>
                <input type="text" id="nome" name="nome" required="required" value="<?= $objFuncoes->tratarCaracter((isset($sala['nome'])) ? ($sala['nome']) : (''), 2) ?>"><br>

                <label>RG: </label><br>
                <input type="text" id="rg" name="rg" required="required" value="<?= isset($sala['rg']) ? ($sala['rg']) : ('') ?>"><br>

                <label>CPF: </label><br>
                <input type="text" name="cpf" id="cpf" required="required" value="<?= isset($sala['cpf']) ? ($sala['cpf']) : ('') ?>"><br>

                <label>E-mail: </label><br>
                <input type="mail" name="email" id="email" required="required" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="<?= $objFuncoes->tratarCaracter((isset($sala['email'])) ? ($sala['email']) : (''), 2) ?>"><br>

                <label>Tipo de usuário: </label><br>
                <select name="tipoUsuario" id="tipoUsuario">
                    <?php foreach ($objFuncoes->tipoUsuario(2) as $key => $value) { ?>
                        <option value="<?= $key ?>"><?= $value ?></option>
                    <?php } ?>
                </select>

                <label>Endereço: </label><br>
                <input type="text" name="endereco" required="required" value="<?= $objFuncoes->tratarCaracter((isset($sala['endereco'])) ? ($sala['endereco']) : (''), 2) ?>"><br>

                <?php if (isset($_GET['acao']) <> 'edit') { ?>
                    <label>Senha: </label><br>
                    <input type="password" name="senha" required="required"><br>
                <?php } ?>
                <br>
                <input type="submit" name="<?= (isset($_GET['acao']) == 'edit') ? ('btAlterar') : ('btCadastrar') ?>" value="<?= (isset($_GET['acao']) == 'edit') ? ('Alterar') : ('Cadastrar') ?>">

                <!--CRIAR BOTÃO PARA LIMPAR FORMULARIO, E VOLTAR A TELA INICIAL-->

                <input type="hidden" name="func" value="<?= (isset($sala['idUsuario'])) ? ($objFuncoes->base64($sala['idUsuario'], 1)) : ('') ?>">
            </form>
        </div>
        <div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Codigo</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Email</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($objUsuario->querySelect() as $rst) {
                        ?>
                        <tr>

                            <th scope="row"><?php echo $rst['idusuario']; ?></th>
                            <td><?php echo $objFuncoes->tratarCaracter($rst['nome'], 2); ?></td>
                            <td><?php echo $rst['email']; ?></td>
                            <td>
                                <div class="">
                                    <a class="editar" href="?acao=edit&func=<?= $objFuncoes->base64($rst['idusuario'], 1) ?>" title="Editar dados"><img src="img/ico-editar.png" width="16" height="16" alt="Editar"></a>
                                    <a class="excluir" href="?acao=delet&func=<?= $objFuncoes->base64($rst['idusuario'], 1) ?>" title="Excluir esse dado"><img src="img/ico-excluir.png" width="16" height="16" alt="Excluir"></a>
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
