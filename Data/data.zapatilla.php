<?php

class Zapatilla
{
    private $id_zapatilla;
    private $nombre;
    private $descripcion;
    private $precio;
    private $img_path;
    private $sexo;

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

    function set_precio($p)
    {
        $this->precio = $p;
    }

    function get_img_path()
    {
        return $this->img_path;
    }

    function set_img_path($path)
    {
        $this->img_path = $path;
    }

    function get_sexo()
    {
        return $this->sexo;
    }

    function set_sexo($s)
    {
        $this->sexo = $s;
    }

}

?>
