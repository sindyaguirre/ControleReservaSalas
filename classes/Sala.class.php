<?php

include_once 'Conexao.class.php';
include_once 'Funcoes.class.php';

class Sala {

    private $con;
    private $objFuncoes;
    private $idsala;
    private $sala;
    private $qtdMaxAlunos;

    /**
     * 
     */
    public function __construct() {
        $this->con = new Conexao();
        $this->objFuncoes = new Funcoes();
    }

    /**
     * 
     * @param type $atributo
     * @param type $valor
     */
    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    /**
     * 
     * @param type $atributo
     * @return type
     */
    public function __get($atributo) {
        return $this->$atributo;
    }

    /**
     * 
     * @param type $dado
     * @return type
     */
    public function querySeleciona($dado) {
        try {
            $this->idsala = $this->objFuncoes->base64($dado, 2);
            $select = $this->con->conectar()->prepare("SELECT * FROM `salas` WHERE `idsala = :idsala;");
            $select->bindParam(":idsala", $this->idsala, PDO::PARAM_INT);
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
            $select = $this->con->conectar()->prepare("SELECT * FROM `salas`;");
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
            
            $this->sala = $this->objFuncoes->tratarCaracter($dados['sala'], 1);
            $this->qtdMaxAlunos = $dados['qtdMaxAlunos'];

            /**
             * fazer verificação de nome de sala já existente
             */
            $cad = $this->con->conectar()->prepare(
                    'INSERT INTO salas (`sala`, `qtdMaxAlunos`)'
                    . ' VALUE (:sala, :qtdMaxAlunos)'
            );
            $cad->bindParam(":sala", $this->sala, PDO::PARAM_STR);
            $cad->bindParam(":qtdMaxAlunos", $this->qtdMaxAlunos, PDO::PARAM_INT);

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
            $this->idsala = $dados['idsala'];
            $this->sala = $this->objFuncoes->tratarCaracter($dados['sala'], 1);
            $this->qtdMaxAlunos = $dados['qtdMaxAlunos'];

            $cst = $this->con->conectar()->prepare("UPDATE `salas` SET `sala` = :sala, `qtdMaxAlunos` = :qtdMaxAlunos WHERE `idsala` = :idsala;");
            $cst->bindParam(":idsala", $this->idsala, PDO::PARAM_INT);
            $cst->bindParam(":sala", $this->sala, PDO::PARAM_STR);
            $cst->bindParam(":qtdMaxAlunos", $this->qtdMaxAlunos, PDO::PARAM_INT);
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
            $this->idsala = $this->objFuncoes->base64($dado, 2);
            $cst = $this->con->conectar()->prepare("DELETE FROM `salas` WHERE `idsala` = :idsala;");
            $cst->bindParam(":idsala", $this->idsala, PDO::PARAM_INT);
            if ($cst->execute()) {
                return 'ok';
            } else {
                return 'erro';
            }
        } catch (PDOException $ex) {
            return 'error' . $ex->getMessage();
        }
    }

    /**
     * 
     * @return type
     */
    public function queryListarSalasHorarios() {
        try {
            $select = $this->con->conectar()->prepare("SELECT * FROM `salas`;");
            $select->execute();
            return $select->fetchAll();
        } catch (Exception $ex) {
            return 'erro ' . $ex->getMessage();
        }
    }

}
