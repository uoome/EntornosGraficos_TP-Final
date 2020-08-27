<?php

class Zapatilla
{
    private $id_zapatilla;
    private $nombre;
    private $color;
    private $precio;

    // Constructor
    function __construct()
    {
        $this->id_zapatilla = -1;
        $this->nombre = "";
        $this->color = "";
        $this->precio = 0.0;
    }

    // Getters y Setters
    function get_id()
    {
        return $this->id_zapatilla;
    }

    function set_id($id)
    {
        $this->id_zapatilla = $id;
    }

    function get_nombre()
    {
        return $this->nombre;
    }

    function set_nombre($nombre)
    {
        $this->nombre = $nombre;
    }

    function get_color()
    {
        return $this->color;
    }

    function set_color($color)
    {
        $this->color = $color;
    }

    function get_precio()
    {
        return $this->precio;
    }

    function set_precio($precio)
    {
        $this->precio = $precio;
    }
}
?>
