<?php
// Anterior
// include("../includes/db.php");

// Nuevo
include_once($_SERVER['DOCUMENT_ROOT'].'/EntornosGraficos_TP-Final/rutas.php');
include(INCLUDES_PATH."db.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM usuario WHERE '$id' = id_usuario;";

    if ($conn->query($sql) === TRUE) {
        // Mensaje exito
        $_SESSION['mensaje'] = "Usuario eliminado con exito !";
        $_SESSION['tipo_mensaje'] = "success";
    } else {
        // Mensaje error
        $_SESSION['mensaje'] = "Error al eliminar usuario: " . $conn->error;
        $_SESSION['tipo_mensaje'] = "danger";
    }

    //Redireccionar al form
    header("Location: ../panel-usuarios.php");
}

?>
