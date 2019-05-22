<?php

include_once 'Conexao.class.php';
include_once 'Funcoes.class.php';

class Usuario {

    private $con;
    private $objFuncoes;
    private $idUsuario;
    private $name;
    private $email;
    private $senha;
    private $dataCadastro;
    private $endereco;

    public function __construct() {
        $this->con = new Conexao();
        $this->objFuncoes = new Funcoes();
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function querySeleciona($dado) {
        try {
            $this->idUsuario = $this->objFuncoes->base64($dado, 2);
            $select = $this->con->conectar()->prepare("SELECT * FROM `usuario` WHERE `idusuario = :idusu;");
            $select->bindParam(":idusu", $this->idUsuario, PDO::PARAM_INT);
            $select->execute();
            return $select->fetch();
        } catch (Exception $ex) {
            return "error " . $ex->getMessage();
        }
    }

    public function querySelect() {
        try {
            $select = $this->con->conectar()->prepare("SELECT * FROM `usuario`;");
            $select->execute();
            return $select->fetchAll();
        } catch (Exception $ex) {
            return 'erro ' . $ex->getMessage();
        }
    }

    public function queryInsert($dados) {
        try {
            $this->name = $this->objFuncoes->tratarCaracter($dados['nome'], 1);
            $this->endereco = $this->objFuncoes->tratarCaracter($dados['endereco'], 1);
            $this->email = $dados['email'];
            $this->senha = sha1($dados['senha']);
            $this->dataCadastro = $this->objFuncoes->dataAtual(2);

            $cad = $this->con->conectar()->prepare(
                    'INSERT INTO ùsuario`(`nome`, `endereco`,`email`,`senha`,`dataCadastro`)'
                    . ' VALUE (:nome, :endereco, :email, :senha, :dt);');
            $cad->bindParam(":nome", $this->nome, PDO::PARAM_STR);
            $cad->bindParam(":endereco", $this->endereco, PDO::PARAM_STR);
            $cad->bindParam(":email", $this->email, PDO::PARAM_STR);
            $cad->bindParam(":senha", $this->senha, PDO::PARAM_STR);
            $cad->bindParam(":dt", $this->dataCadastro, PDO::PARAM_STR);
            if ($cad->execute()) {
                return 'ok';
            } else {
                return 'erro';
            }
        } catch (Exception $ex) {
            return 'error '.$ex->getMessage();
        }
    }
        public function queryUpdate($dados){
        try{
            $this->idUsuario = $this->objFuncoes->base64($dados['usuario'], 2);
            $this->nome = $this->objFuncoes->tratarCaracter($dados['nome'], 1);
            $this->endereco = $this->objFuncoes->tratarCaracter($dados['endereco'], 1);
            $this->email = $dados['email'];
            $cst = $this->con->conectar()->prepare("UPDATE `usuario` SET  `nome` = :nome, `endereco` = :endereco, `email` = :email WHERE `idusuario` = :idusu;");
            $cst->bindParam(":idusu", $this->idUsuario, PDO::PARAM_INT);
            $cst->bindParam(":nome", $this->nome, PDO::PARAM_STR);
            $cst->bindParam(":endereco", $this->endereco, PDO::PARAM_STR);
            $cst->bindParam(":email", $this->email, PDO::PARAM_STR);
            if($cst->execute()){
                return 'ok';
            }else{
                return 'erro';
            }
        } catch (PDOException $ex) {
            return 'error '.$ex->getMessage();
        }
    }

    public function queryDelete($dado){
        try{
            $this->idUsuario = $this->objFuncoes->base64($dado, 2);
            $cst = $this->con->conectar()->prepare("DELETE FROM `usuario` WHERE `idusuario` = :idusu;");
            $cst->bindParam(":idusu", $this->idUsuario, PDO::PARAM_INT);
            if($cst->execute()){
                return 'ok';
            }else{
                return 'erro';
            }
        } catch (PDOException $ex) {
            return 'error'.$ex->getMessage();
        }
    }

}
