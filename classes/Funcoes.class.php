<?php

class Funcoes {

    /**
     * 
     * @param type $param 1 retorna string, 2 retorna array
     * @param type $id se o primeiro parametro receber 1, este é obrigatório
     * @return int
     */
    public function returnTempoEstimado($param, $id = "") {

        $arrayDados = array(
            "Selecione...",
            "2 horas",
            "4 horas",
            "6 horas",
            "8 horas"
        );
        switch ($param) {
            case '1':
                return $arrayDados[$id];
                break;

            case '2':
                return $arrayDados;
                break;

            default:
                return 0;
                break;
        }
    }

    /**
     * 
     * @param type $param 
     *  1 retorna string, utilizar em vizualização 
     *  2 retorna array
     * @param type $id se o primeiro parametro receber 1, este é obrigatório
     * @return int
     */
    public function returnStatus($param, $id = "") {

        $arrayDados = array(
            "Selecione...",
            "Liberada",
            "Ocupada"
        );
        switch ($param) {
            case '1':

                return $arrayDados[$id];
                break;

            case '2':

                return $arrayDados;
                break;

            default:
                return 0;
                break;
        }
    }


    public function tratarCaracter($vlr, $tipo) {
        switch ($tipo) {
            case 1: $rst = utf8_decode($vlr);
                break;
            case 2: $rst = utf8_encode($vlr);
                break;
            case 3: $rst = htmlentities($vlr, ENT_QUOTES, "ISO-8859-1");
                break;
        }
        return $rst;
    }

    public function dataAtual($tipo) {
        switch ($tipo) {
            case 1: $rst = date("Y-m-d");
                break;
            case 2: $rst = date("Y-m-d H:i:s");
                break;
            case 3: $rst = date("d/m/Y");
                break;
        }
        return $rst;
    }

    public function base64($vlr, $tipo) {
        switch ($tipo) {
            case 1: $rst = base64_encode($vlr);
                break;
            case 2: $rst = base64_decode($vlr);
                break;
        }
        return $rst;
    }

}

?>
