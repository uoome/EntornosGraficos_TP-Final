<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/EntornosGraficos_TP-Final/rutas.php');
include_once(DAO_PATH."db.php");
include_once(INCLUDES_PATH."validacion.forms.admin.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_contacto = $email_contacto = $comentario = null;

    if(isset($_POST['nombre_contacto'])) $nombre_contacto = test_input($_POST['nombre_contacto']);
    if(isset($_POST['email_contacto'])) $email_contacto = test_input($_POST['email_contacto']);
    if(isset($_POST['coment_contacto'])) { 
        $comentario = stripslashes($_POST['coment_contacto']); // Quitar '\'
        $comentario = htmlspecialchars($comentario); // Formatear caracteres especiales
    }

    echo "Datos: " . $nombre_contacto . " " . $email_contacto . " " . $comentario .". <br>";
    echo "Falta realizar funcionalidad de mail recibido";
}

?>