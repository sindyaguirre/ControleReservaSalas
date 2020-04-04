<?php

include_once 'Conexao.class.php';
include_once 'Funcoes.class.php';

class Reservas {

    private $con;
    private $objFuncoes;
    private $idreserva;
    private $idsala;
    private $idusuario;
    private $idhorarioReservado;
    private $dataReserva;
    private $dataCadastro;

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
            $this->idreserva = $this->objFuncoes->base64($dado, 2);
            $select = $this->con->conectar()->prepare("SELECT * FROM `reserva` WHERE `idreserva` = :idreserva;");
            $select->bindParam(":idreserva", $this->idsala, PDO::PARAM_INT);
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
            $this->idsala = $dados['idsala'];
            $this->idusuario = $_SESSION['idusuario'];
            $this->idhorarioReservado = $dados['idhorario'];
            /**
             * verificando data
             */
            if ($dados['dataReserva'] < date('Y-m-d')) {
                return array('status' => false, 'msg' => "Data de reserva deve ser maior ou igual a data atual.");
            }
            $this->dataReserva = $dados['dataReserva'];
            $this->dataCadastro = $this->objFuncoes->dataAtual(1);


            /**
             * fazer verificação de nome de sala já existente
             */
//            $cad = $this->con->conectar()->prepare(
//                    'INSERT INTO reserva (`idusuario`) VALUE (:idusuario);'
//                    'INSERT INTO reserva (`idsala`,`idusuario`,`idhorarioReservado`,`dataReserva`,`dataCadastro`) VALUE (:idsala, :idusuario, :idhorarioReservado, :dataReserva, :dataCadastro)'
//            );

//            $cad->bindParam(":idusuario", $this->idusuario, PDO::PARAM_INT);
//            $cad->bindParam(":idusuario", $this->idusuario, PDO::PARAM_INT);
//            $cad->bindParam(":idhorarioReservado", $this->idhorarioReservado, PDO::PARAM_INT);
//            $cad->bindParam(":dataReserva", $this->dataReserva, PDO::PARAM_STR);
//            $cad->bindParam(":dataCadastro", $this->dataCadastro, PDO::PARAM_STR);

            $cad = $this->con->conectar()->prepare(
                    'INSERT INTO reserva (`idsala`, `idusuario`,`dataCadastro`)'
                    . ' VALUE (:idsala, :idusuario, :dt);');
            $cad->bindParam(":idsala", $this->idsala, PDO::PARAM_INT);
            $cad->bindParam(":idusuario", $this->idusuario, PDO::PARAM_INT);
            $cad->bindParam(":dt", $this->dataCadastro, PDO::PARAM_STR);
            if ($cad->execute()) {
                return array('status' => true);
            } else {
                return array('status' => false, 'msg' => "Em Construção!");
            }
        } catch (Exception $ex) {
            return array('status' => false, 'msg' => 'error ' . $ex->getMessage());
        }
    }

    public function queryUpdate($dados) {
        /*
          idreserva idsala idusuario horarioReservado dataReserva dataCadastro
         *  */
        try {
            $this->idreserva = $dados['idreserva'];
            $this->idsala = $dados['idsala'];
            $this->idusuario = $dados['idusuario'];
            $this->idhorarioReservado = $dados['idhorarioReservado'];
            $this->dataReserva = $dados['dataReserva'];
            $this->dataCadastro = $dados['dataCadastro'];

            $cst = $this->con->conectar()->prepare("UPDATE "
                    . "reserva` SET `idsala` = :idsala, `idusuario`= :idusuario, `idhorarioReservado` = :horarioReservado,
                    `dataReserva`= :idhorarioReservado, `dataCadastro` :dataCadastro
                    WHERE `idreserva` = :idreserva;");
            $cst->bindParam(":idsala", $this->idsala, PDO::PARAM_INT);
            $cst->bindParam(":idusuario", $this->idusuario, PDO::PARAM_INT);
            $cst->bindParam(":idhorarioReservado", $this->idhorarioReservado, PDO::PARAM_INT);
            $cst->bindParam(":dataReserva", $this->dataReserva, PDO::PARAM_STR);
            $cst->bindParam(":dataCadastro", $this->dataCadastro, PDO::PARAM_STR);
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
            $this->idreserva = $this->objFuncoes->base64($dado, 2);
            $cst = $this->con->conectar()->prepare("DELETE FROM `reserva` WHERE `idreserva` = :idreserva;");
            $cst->bindParam(":idreserva", $this->idreserva, PDO::PARAM_INT);
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
