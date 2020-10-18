<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/EntornosGraficos_TP-Final/rutas.php');
include_once(DAO_PATH."db.php");
include_once(DAO_PATH."dao.zapatilla.php");
include_once(DATA_PATH."data.zapatilla.php");
include_once(INCLUDES_PATH."validacion.forms.admin.php");

// Iniciar/Retornar sesion
session_start();

// Logica si hay POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Variables
    $nombre = $precio = $descripcion = $img_path = null;

    if (validarDatosZapatilla()) {
        // Guardar datos
        $zapatillaService = new ZapatillaDataService(); // Servicio DAO
        $zapaToInsert = new Zapatilla(); // Data Class
        $zapaToInsert->set_nombre($nombre);
        $zapaToInsert->set_precio($precio);
        $zapaToInsert->set_descripcion($descripcion);
        $zapaToInsert->set_img_path($img_path);
        // Insert
        $result = $zapatillaService->insertZapa($zapaToInsert);

        if ($result) {
            // Mensaje exito
            $_SESSION['mensaje'] = "Zapatilla cargada con exito !";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            // Mensaje error
            $_SESSION['mensaje'] = "Error al guardar zapatilla.";
            $_SESSION['tipo_mensaje'] = "danger";
        }
    } else {
        $_SESSION['mensaje'] = "<strong>Ups!</strong> Complete los datos correctamente";
        $_SESSION['tipo_mensaje'] = "warning";
    }

    //Redireccionar al form
    header("Location: ../registro.zapatilla.php");
}

?>
