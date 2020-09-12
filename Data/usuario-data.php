<?php
// Anterior
// include("usertype-enum.php");

// Nuevo
include_once($_SERVER['DOCUMENT_ROOT'].'/EntornosGraficos_TP-Final/rutas.php');
include(DATA_PATH."usertype-enum.php");

class Usuario
{
    // Variables
    private $id_usuario;
    private $nombre;
    private $apellido;
    private $username;
    private $password;
    private $email;
    private $telefono;
    private $tipo;

    // Constructor
    function __construct()
    {
        $this->id_usuario = '';
        $this->nombre = '';
        $this->apellido = '';
        $this->username = '';
        $this->password = '';
        $this->email = '';
        $this->telefono = '';
        $this->tipo = '';
    }

    // Getters y Setters

    function get_id()
    {
        return $this->id_usuario;
    }

    function set_id($id)
    {
        $this->id_usuario = $id;
    }

    function get_nombre()
    {
        return $this->nombre;
    }

    function set_nombre($nombre)
    {
        $this->nombre = $nombre;
    }

    function get_apellido()
    {
        return $this->apellido;
    }

    function set_apellido($apellido)
    {
        $this->apellido = $apellido;
    }
    
    function get_username()
    {
        return $this->username;
    }

    function set_username($username)
    {
        $this->username = $username;
    }

    function get_password()
    {
        return $this->password;
    }

    function set_password($password)
    {
        $this->password = $password;
    }

    function get_email()
    {
        return $this->email;
    }

    function set_email($email)
    {
        $this->email = $email;
    }

    function get_telefono()
    {
        return $this->telefono;
    }

    function set_telefono($tel)
    {
        $this->telefono = $tel;
    }

    function get_tipo()
    {
        return $this->tipo;
    }

    function set_tipo($tipo)
    {
        switch($tipo) {
            case 1: 
                $this->tipo = UserTypeEnum::Administrator;
            break;
            case 2:
                $this->tipo = UserTypeEnum::Client; 
        }
    }
}
?>
