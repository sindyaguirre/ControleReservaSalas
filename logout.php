<?php
session_start(); //iniciamos a sessao que foi aberta
 
session_destroy(); //destruimos a sessão
 
session_unset(); //limpamos as variaveis globais das sessoes

/*redirecionando para pagina inicial*/

header('location: /ControleReservaSalas/home.php');

