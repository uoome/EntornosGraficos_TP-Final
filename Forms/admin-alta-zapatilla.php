<?php
// Anterior
// include("../includes/db.php");
// include("../Data/usuario-data.php");
// include("../includes/validacion-forms-admin.php");

// Nuevo
include_once($_SERVER['DOCUMENT_ROOT'].'EntornosGraficos_TP-Final/rutas.php');
include_once(INCLUDES_PATH."db.php");
// include_once(DATA_PATH."usuario-data.php");
include_once(INCLUDES_PATH."validacion-forms-admin.php");

// Logica si hay POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Variables
    $nombre = $color = $precio = $img_path = null;

    if (validarDatosZapatilla()) {
        // Armar y ejecutar query
        $sql = "INSERT INTO `zapatilla`(nombre, color, precio, img_path) VALUES (?,?,?,?);";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssds", $nombre, $color, $precio ,$img_path);

        if ($stmt->execute() === TRUE) {
            // Mensaje exito
            $_SESSION['mensaje'] = "Zapatilla cargada con exito !";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            // Mensaje error
            $_SESSION['mensaje'] = "Error: " . $sql . "<br>" . $conn->error;
            $_SESSION['tipo_mensaje'] = "danger";
        }
        // Cerrar prep
        $stmt->close();
    } else {
        $_SESSION['mensaje'] = "<strong>Ups!</strong> Complete los datos correctamente";
        $_SESSION['tipo_mensaje'] = "warning";
    }

    //Redireccionar al form
    header("Location: ../registro-zapatilla.php");
}

?>
