<?php

/**
 * Clase que se encarga de manejar la alta y modificacion de:
 * - Usuario Administrador
 * - Usuario Cliente
 */

include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
include_once(DAO_PATH . "db.php");
include_once(DAO_PATH . "dao.usuario.php");
include_once(INCLUDES_PATH . "validacion.forms.admin.php");

// Iniciar/Retornar sesion
session_start();

// Logica si hay POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_perfil'])) {

    // Variables 
    $nombre = $apellido = $username = $password = $email = null;

    // Realizar validacion
    if (validarDatosUsuario()) {
        // Service
        $usuarioService = new UsuarioService();

        // Cargar usuario admin
        $new_profile = new Usuario();
        $new_profile->set_nombre($nombre);
        $new_profile->set_apellido($apellido);
        $new_profile->set_email($email);
        $new_profile->set_username($username);
        $new_profile->set_password($password);
        $new_profile->set_id($_SESSION['usuarioActual']->get_id());
        $new_profile->set_tipo($_SESSION['usuarioActual']->get_tipo());

        // Update
        if (isset($password)) $result = $usuarioService->updateUserWithPass($new_profile);
        else $result = $usuarioService->updateUserWithoutPass($new_profile);

        // Mensajes 
        if ($result) {
            // Mensaje exito
            $_SESSION['mensaje'] = "Perfil modificado con exito! Reloguee para ver los cambios.";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            // Mensaje error
            $_SESSION['mensaje'] = "Error al modificar perfil.";
            $_SESSION['tipo_mensaje'] = "danger";
        }
    } 
} else {
    // Mensaje error
    $_SESSION['mensaje'] = "Error de request.";
    $_SESSION['tipo_mensaje'] = "danger";
}

// Redirect al perfil
header("Location: ../perfil.php");
