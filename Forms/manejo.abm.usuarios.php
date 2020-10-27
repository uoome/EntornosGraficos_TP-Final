<?php
/**
 * Clase que se encarga de manejar la alta y modificacion de:
 * - Usuario Administrador
 * - Usuario Cliente
 */

include_once($_SERVER['DOCUMENT_ROOT'].'/EntornosGraficos_TP-Final/rutas.php');
include_once(DAO_PATH."db.php");
include_once(DAO_PATH."dao.usuario.php");
include_once(INCLUDES_PATH."validacion.forms.admin.php");

// Iniciar/Retornar sesion
session_start();

// Logica si hay POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Variables 
    $nombre = $apellido = $username = $password = $email = $telefono = $type = null;

    // Realizar validacion
    if (validarDatosUsuario()) {
        // Service
        $usuarioService = new UsuarioService();
        
        // Validar 2 caminos de alta: Admin y Client
        if(isset($_POST['save_admin'])) {
            // Cargar usuario admin
            $new_admin = new Usuario();
            $new_admin->set_nombre($nombre);
            $new_admin->set_apellido($apellido);
            $new_admin->set_email($email);
            $new_admin->set_username($username);
            $new_admin->set_password($password);
            $new_admin->set_telefono($telefono);
            $new_admin->set_tipo($type);
            // Insert
            $result = $usuarioService->insertAdmin($new_admin);
            // Mensajes
            if ($result) {
                // Mensaje exito
                $_SESSION['mensaje'] = "Usuario creado con exito !";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                // Mensaje error
                $_SESSION['mensaje'] = "Error al guardar usuario.";
                $_SESSION['tipo_mensaje'] = "danger";
            }
            // Redirect al form de carga
            header("Location: ../registro.administrador.php");

            // Si es alta cliente
        } elseif(isset($_POST['save_client'])) { 
            // Cargar usuario cliente
            $new_client = new Usuario();
            $new_client->set_nombre($nombre);
            $new_client->set_apellido($apellido);
            $new_client->set_email($email);
            $new_client->set_username($username);
            $new_client->set_password($password);
            $new_client->set_tipo($type);
            // Insert
            $result = $usuarioService->insertClient($new_client);
            // Mensajes 
            if ($result) {
                // Mensaje exito
                $_SESSION['mensaje'] = "Usuario creado con exito !";
                $_SESSION['tipo_mensaje'] = "success";
                // Redirect login
                header("Location: ../login.php");
            } else {
                // Mensaje error
                $_SESSION['mensaje'] = "Error al registrar usuario.";
                $_SESSION['tipo_mensaje'] = "danger";
                // Redirect al formulario
                header("Location: ../registro.cliente.php");
            }
        } elseif(isset($_POST['update_user'])) {
            // Fetch datos a modificar
            $userToUpdate = new Usuario();
            $userToUpdate->set_id($_POST['idUserToUpdate']); // Guardar ID de usuario a modificar
            $userToUpdate->set_nombre($nombre);
            $userToUpdate->set_apellido($apellido);
            $userToUpdate->set_email($email);
            $userToUpdate->set_username($username);
            $userToUpdate->set_password($password);
            $userToUpdate->set_telefono($telefono);
            $userToUpdate->set_tipo($type);

            // Update
            if(isset($password)) $result = $usuarioService->updateUserWithPass($userToUpdate);
            else $result = $usuarioService->updateUserWithoutPass($userToUpdate);
            
            // Mensajes 
            if ($result) {
                // Mensaje exito
                $_SESSION['mensaje'] = "Usuario modificado con exito !";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                // Mensaje error
                $_SESSION['mensaje'] = "Error al modificar usuario.";
                $_SESSION['tipo_mensaje'] = "danger";
            }
            // Redirect al panel de usuarios
            header("Location: ../panel.usuarios.php");
        }
    } else {
        $_SESSION['mensaje'] = "<strong>Ups!</strong> Complete los datos correctamente";
        $_SESSION['tipo_mensaje'] = "warning";
        // die(var_dump($_SERVER['HTTP_REFERER']));
        header("Location: " . $_SERVER['HTTP_REFERER']);
        // Redirect al formulario
        // header("Location: ../registro.cliente.php");
    }
} else {
    // Mensaje error
    $_SESSION['mensaje'] = "Error al enviar formulario por metodo POST.\n";
    $_SESSION['tipo_mensaje'] = "danger";
    header("Location: ../panel.usuarios.php");
}

?>