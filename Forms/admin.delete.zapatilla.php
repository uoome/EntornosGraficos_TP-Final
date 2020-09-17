<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/EntornosGraficos_TP-Final/rutas.php');
include(DAO_PATH."db.php");
include(DAO_PATH."dao.zapatilla.php");

// Iniciar/Retomar session
session_start();

if (isset($_GET['id'])) {
    $result = false;
    // Fecth id
    $id = $_GET['id'];
    // Service
    $zapatillaService = new ZapatillaDataService();
    // Validar si existe el registro a eliminar
    $existe = $zapatillaService->validarExistenciaDeZapatilla($id);

    // Si existe -> Eliminar
    if($existe) $result = $zapatillaService->deleteZapatilla($id);
    else {
        // Mensaje error
        $_SESSION['mensaje'] = "El registro a eliminar no existe.";
        $_SESSION['tipo_mensaje'] = "danger";
    }

    if ($result) {
        // Mensaje exito
        $_SESSION['mensaje'] = "Zapatilla eliminada con exito !";
        $_SESSION['tipo_mensaje'] = "success";
    } else {
        // Mensaje error
        $_SESSION['mensaje'] = "Error al eliminar zapatilla.";
        $_SESSION['tipo_mensaje'] = "danger";
    }

    //Redireccionar al form
    header("Location: ../panel.zapatillas.php");
}

?>
