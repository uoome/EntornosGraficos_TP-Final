<?php 

class Usuario{
    // Variables
    private $id_usuario;
    private $nombre;
    private $password;
    private $email;
    private $telefono;
    private $tipo;

    // Getters y Setters

    function get_id() {
        return $this->id_usuario;
    }

    function set_id($id) {
        $this->id_usuario = $id;
    }

    function get_nombre() {
        return $this->nombre;
    }

    function set_nombre($nombre) {
        $this->nombre = $nombre;
    }
    
    function get_password() {
        return $this->id_usuario;
    }

    function set_password($password) {
        $this->password = $password;
    }

    function get_email() {
        return $this->email;
    }

    function set_email($email) {
        $this->email = $email;
    }

    function get_telefono() {
        return $this->telefono;
    }

    function set_telefono($tel) {
        $this->telefono = $tel;
    }

    function get_tipo() {
        return $this->tipo;
    }

    function set_tipo($tipo) {
        $this->tipo = $tipo;
    }
}
