<?php

include_once 'Conexao.class.php';
include_once 'Funcoes.class.php';

/**
 * Description of Reserva
 *
 * @author sindy.aguirre
 */
class Reserva {

    public $con;
    public $objFuncoes;
    public $idreserva;
    public $idusuario;
    public $idhorario;
    public $idturno;
    public $idsala;
    public $datacadastro;
    public $datareserva;

    public function __construct() {
        $this->con = new Conexao();
        $this->objFuncoes = new Funcoes();
    }

    /**
     * 
     * @param type $atributo
     * @return type
     */
    function __get($atributo) {
        return $this->$atributo;
    }

    /**
     * 
     * @param type $atributo
     * @param type $valor
     */
    function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    /**
     * 
     * @param type $dado
     * @return type
     */
    public function querySeleciona($dado) {
        try {
            $this->idreserva = $dado;
            $select = $this->con->conectar()->prepare("SELECT * FROM `reserva` WHERE `idreserva = :idreserva;");
            $select->bindParam(":idreserva", $this->idreserva, PDO::PARAM_INT);
            $select->execute();
            return $select->fetch();
        } catch (Exception $ex) {
            return "error " . $ex->getMessage();
        }
    }

    /**
     * 
     * @return type
     */
    public function querySelect() {
        try {
            $select = $this->con->conectar()->prepare("SELECT * FROM `reserva`;");
            $select->execute();
            return $select->fetchAll();
        } catch (Exception $ex) {
            return 'erro ' . $ex->getMessage();
        }
    }

    /**
     * 
     * @param type $dados
     * @return string
     */
    public function queryInsert($dados) {
        try {
            $this->idusuario = $dados['idusuario'];
            $this->idsala = $dados['idsala'];
            $this->idhorario = $dados['idhorario'];
            $this->idturno = $dados['idturno'];
            $this->dataReserva = $dados['idusuario'];
            $this->dataCadastro = $this->objFuncoes->dataAtual(2);

//            $cad = $this->con->conectar()->prepare(
//                    'INSERT INTO usuario (`nome`, `endereco`,`email`,`tipoUsuario`,`senha`,`dataCadastro`)'
//                    . ' VALUE (:nome, :endereco, :email, :tipoUsuario, :senha, :dt);');
//            $cad->bindParam(":nome", $this->nome, PDO::PARAM_STR);
//            $cad->bindParam(":endereco", $this->endereco, PDO::PARAM_STR);
//            $cad->bindParam(":email", $this->email, PDO::PARAM_STR);
//            $cad->bindParam(":tipoUsuario", $this->tipoUsuario, PDO::PARAM_INT);
//            $cad->bindParam(":senha", $this->senha, PDO::PARAM_STR);
//            $cad->bindParam(":dt", $this->dataCadastro, PDO::PARAM_STR);
//            var_dump($this);
//            die('debug');
            if ($cad->execute()) {
                return 'ok';
            } else {
                return 'erro';
            }
        } catch (Exception $ex) {
            return 'error ' . $ex->getMessage();
        }
    }

    public function queryUpdate($dados) {
        try {
//            $this->idusuario = $dados['idusuario'];
//            $this->nome = $this->objFuncoes->tratarCaracter($dados['nome'], 1);
//            $this->endereco = $this->objFuncoes->tratarCaracter($dados['endereco'], 1);
//            $this->email = $dados['email'];
//            $this->tipoUsuario = $dados['tipoUsuario'];
//            $cst = $this->con->conectar()->prepare("UPDATE `usuario` SET `nome` = :nome, `tipoUsuario` = :tipoUsuario, `endereco` = :endereco, `email` = :email WHERE `idusuario` = :idusu;");
//            $cst->bindParam(":idusu", $this->idusuario, PDO::PARAM_INT);
//            $cst->bindParam(":nome", $this->nome, PDO::PARAM_STR);
//            $cst->bindParam(":endereco", $this->endereco, PDO::PARAM_STR);
//            $cst->bindParam(":email", $this->email, PDO::PARAM_STR);
//            $cst->bindParam(":tipoUsuario", $this->tipoUsuario, PDO::PARAM_INT);
            if ($cst->execute()) {
                return 'ok';
            } else {
                return 'erro';
            }
        } catch (PDOException $ex) {
            return 'error ' . $ex->getMessage();
        }
    }

    public function queryDelete($dado) {

        try {
            $this->idusuario = $this->objFuncoes->base64($dado, 2);
            $cst = $this->con->conectar()->prepare("DELETE FROM `usuario` WHERE `idusuario` = :idusu;");
            $cst->bindParam(":idusu", $this->idusuario, PDO::PARAM_INT);
            if ($cst->execute()) {
                return 'ok';
            } else {
                return 'erro';
            }
        } catch (PDOException $ex) {
            return 'error' . $ex->getMessage();
        }
    }

}
