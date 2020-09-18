<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/EntornosGraficos_TP-Final/rutas.php');
include(DAO_PATH."db.php");
include(DAO_PATH."dao.usuario.php");

// Iniciar/Retomar session
session_start();

if (isset($_GET['id'])) {
    $resul = false;
    // Fetch id
    $id = $_GET['id'];
    // Service
    $usuarioService = new UsuarioService();
    // Validar si existe el registro
    $existe = $usuarioService->existeUsuario($id);

    if($existe) {
        $resul = $usuarioService->deleteUsuario($id);

        if ($resul) {
            // Mensaje exito
            $_SESSION['mensaje'] = "Usuario eliminado con exito !";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            // Mensaje error
            $_SESSION['mensaje'] = "Error al eliminar usuario: " . $conn->error;
            $_SESSION['tipo_mensaje'] = "danger";
        }
    } else {
        // Mensaje error
        $_SESSION['mensaje'] = "El registro a eliminar no existe.";
        $_SESSION['tipo_mensaje'] = "danger";
    }

    //Redireccionar al form
    header("Location: ../panel.usuarios.php");
}

?>
