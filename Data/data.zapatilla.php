<?php

class Zapatilla
{
    private $id_zapatilla;
    private $nombre;
    private $color;
    private $descripcion;
    private $precio;
    private $img_path;
    private $talle;

    // Constructor
    function __construct() {}

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

    function get_descripcion()
    {
        return $this->descripcion;
    }

    function set_descripcion($desc)
    {
        $this->descripcion = $desc;
    }

    function get_precio()
    {
        return $this->precio;
    }

    function set_precio($precio)
    {
        $this->precio = $precio;
    }

    function get_img_path()
    {
        return $this->img_path;
    }

    function set_img_path($path)
    {
        $this->img_path = $path;
    }

    function get_talle()
    {
        return $this->talle;
    }

    function set_talle($t)
    {
        $this->talle = $t;
    }
}
?>
