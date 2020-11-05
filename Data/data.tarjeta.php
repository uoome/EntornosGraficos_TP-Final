<?php

class TarjetaCredito
{
    // Variables
    private $id_tarjeta;
    private $nombre_tarjeta;
    private $nro_tarjeta;
    private $fecha_vencimiento;
    private $cvv;
    private $idUsuario;

    // Getters y Setters

    function get_id()
    {
        return $this->id_tarjeta;
    }

    function set_id($id)
    {
        $this->id_tarjeta = $id;
    }

    function get_nombreTarjeta()
    {
        return $this->nombre_tarjeta;
    }

    function set_nombreTarjeta($nom)
    {
        $this->nombre_tarjeta = $nom;
    }

    function get_nroTarjeta()
    {
        return $this->nro_tarjeta;
    }

    function set_nroTarjeta($nro)
    {
        $this->nro_tarjeta = $nro;
    }

    function get_fechaVencimiento()
    {
        return $this->fecha_vencimiento;
    }

    function set_fechaVencimiento($fv)
    {
        $this->fecha_vencimiento = $fv;
    }

    function get_cvv()
    {
        return $this->cvv;
    }

    function set_cvv($code)
    {
        $this->cvv = $code;
    }

    function get_idUsuario()
    {
        return $this->idUsuario;
    }

    function set_idUsuario($user)
    {
        $this->idUsuario = $user;
    }
}

?>
