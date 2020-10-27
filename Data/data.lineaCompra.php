<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/EntornosGraficos_TP-Final/rutas.php');
include_once(DAO_PATH."db.php");
include_once(DAO_PATH."dao.usuario.php");
include_once(DAO_PATH."dao.zapatilla.php");

class LineaCompra {

    private $id_lineaCompra;
    private $id_carro;
    private $id_zapatilla;
    private $qty;
    private $color;
    private $talle;
    private $subtotal_linea;

    function _construct() {
    }

    function get_idLineaCompra() {
        return $this->id_lineaCompra;
    }
    function set_idLineaCompra($idLC) {
        $this->id_lineaCompra = $idLC;
    }

    function get_idCarro() {
        return $this->id_carro;
    }
    function set_idCarro($idC) {
        $this->id_carro = $idC;
    }

    function get_idZapatilla() {
        return $this->id_zapatilla;
    }
    function set_idZapatilla($idZapa) {
        $this->id_zapatilla = $idZapa;
    }

    function get_qty() {
        return $this->qty;
    }
    function set_qty($q) {
        $this->qty = $q;
    } 

    function get_color() {
        return $this->color;
    }
    function set_color($col) {
        $this->color = $col;
    }
    function get_talle() {
        return $this->talle;
    }
    function set_talle($t) {
        $this->talle = $t;
    }

    function get_subtotalLinea() {
        return $this->subtotal_linea;
    }
    function set_subtotalLinea($subtot) {
        $this->subtotal_linea = $subtot;
    }

    /** 
    * Trae la zapatilla desde la DB, con id de zapatilla presente en la clase
    * @return null|Zapatilla 
    */
    function get_zapatilla() 
    {
        $zapatillaService = new ZapatillaDataService();
        return $zapatillaService->getZapatilla($this->id_zapatilla);    
    }

}

?>