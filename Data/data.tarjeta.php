<?php

class TarjetaCredito
{
    // Variables
    private $id_tarjeta;
    private $fecha_alta;
    private $fecha_vencimiento;
    private $usuario;

    // Getters y Setters

    function get_id()
    {
        return $this->id_tarjeta;
    }

    function set_id($id)
    {
        $this->id_tarjeta = $id;
    }

    function get_fechaAlta()
    {
        return $this->fecha_alta;
    }

    function set_fechaAlta($fa)
    {
        $this->fecha_alta = $fa;
    }

    function get_fechaVencimiento()
    {
        return $this->fecha_vencimiento;
    }

    function set_fechaVencimiento($fv)
    {
        $this->fecha_vencimiento = $fv;
    }
    function get_usuario()
    {
        return $this->usuario;
    }

    function set_usuario($user)
    {
        $this->usuario = $user;
    }
}

?>
