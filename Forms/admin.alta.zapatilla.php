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
    $id = $nombre = $precio = $sexo = $descripcion = $img_path = null;

    if(isset($_POST['insert_zapa'])) {
        if (validarDatosZapatilla()) {
            // Guardar datos
            $zapatillaService = new ZapatillaDataService(); // Servicio DAO
            $zapaToInsert = new Zapatilla(); // Data Class
            $zapaToInsert->set_nombre($nombre);
            $zapaToInsert->set_precio($precio);
            $zapaToInsert->set_descripcion($descripcion);
            $zapaToInsert->set_sexo($sexo);
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
            // Redirect al form
            header("Location: ../registro.zapatilla.php");
        }
    } elseif(isset($_POST['update_zapa'])) {
        if (validarDatosZapatilla()) {
            // Fetch datos a modificar
            $zapaToUpdate = new Zapatilla();
            $zapaToUpdate->set_id($_POST['idZapaToUpdate']);
            $zapaToUpdate->set_nombre($nombre);
            $zapaToUpdate->set_descripcion($descripcion);
            $zapaToUpdate->set_precio($precio);
            $zapaToUpdate->set_img_path($img_path);
            $zapaToUpdate->set_sexo($sexo);

            // die(var_dump($zapaToUpdate));

            $zapatillaService = new ZapatillaDataService(); // Servicio DAO
            // Update
            if(isset($img_path)) $result = $zapatillaService->updateZapaWithImage($zapaToUpdate);
            else $result = $zapatillaService->updateZapaWithoutImage($zapaToUpdate);

            if ($result) {
                // Mensaje exito
                $_SESSION['mensaje'] = "Zapatilla modificada con exito !";
                $_SESSION['tipo_mensaje'] = "success";
                header("Location: ../panel.zapatillas.php");
            } else {
                // Mensaje error
                $_SESSION['mensaje'] = "Error al guardar datos de zapatilla en DB.";
                $_SESSION['tipo_mensaje'] = "danger";
                header("Location: " . $_SERVER['HTTP_REFERER']);
            }
        } else {
            $_SESSION['mensaje'] = "<strong>Ups!</strong> Complete los datos correctamente";
            $_SESSION['tipo_mensaje'] = "warning";
            header("Location: " . $_SERVER['HTTP_REFERER']);
        }
    } else {
        $_SESSION['mensaje'] = "Error de request.";
        $_SESSION['tipo_mensaje'] = "danger";
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }        
} else {
    $_SESSION['mensaje'] = "Error de request.";
    $_SESSION['tipo_mensaje'] = "danger";
    header("Location: " . $_SERVER['HTTP_REFERER']);
}

?>
