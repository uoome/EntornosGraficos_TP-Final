<?php

class Compra
{
    // Variables
    private $id_compra;
    private $usuario;
    private $carro;
    private $total;
    private $fecha_compra;
    private $tipo_pago;
    private $tarjeta;
    private $direccion_entrega;

    // Getters y Setters
    function get_id()
    {
        return $this->id_compra;
    }

    function set_id($id)
    {
        $this->id_compra = $id;
    }
    function get_usuario()
    {
        return $this->usuario;
    }

    function set_usuario($usuario)
    {
        $this->usuario = $usuario;
    }
    function get_carro()
    {
        return $this->carro;
    }

    function set_carro($carro)
    {
        $this->carro = $carro;
    }
    function get_total()
    {
        return $this->total;
    }

    function set_total($total)
    {
        $this->total = $total;
    }
    function get_fechaCompra()
    {
        return $this->fecha_compra;
    }

    function set_fechaCompra($fc)
    {
        $this->fecha_compra = $fc;
    }
    function get_tipoPago()
    {
        return $this->tipo_pago;
    }

    function set_tipoPago($pago)
    {
        $this->tipo_pago = $pago;
    }

    function get_tarjeta()
    {
        return $this->tarjeta;
    }

    function set_tarjeta($tarjeta)
    {
        $this->tarjeta = $tarjeta;
    }

    function get_direccionEntrega()
    {
        return $this->direccion_entrega;
    }

    function set_direccionEntrega($dir)
    {
        $this->direccion_entrega = $dir;
    }
}
?>