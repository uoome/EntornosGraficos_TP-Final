<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/EntornosGraficos_TP-Final/rutas.php');
include_once(DAO_PATH."db.php");
include_once(INCLUDES_PATH."validacion.forms.admin.php");

session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_contacto = $email_contacto = $comentario = null;

    if(isset($_POST['nombre_contacto'])) $nombre_contacto = test_input($_POST['nombre_contacto']);
    if(isset($_POST['email_contacto'])) $email_contacto = test_input($_POST['email_contacto']);
    if(isset($_POST['coment_contacto'])) { 
        $comentario = stripslashes($_POST['coment_contacto']); // Quitar '\'
        $comentario = htmlspecialchars($comentario); // Formatear caracteres especiales
    }
    // echo "Datos: " . $nombre_contacto . " " . $email_contacto . " " . $comentario .". <br>";
    // Armar mail
    $to = "nicogomezwp@gmail.com";
    $subject = "Formulario Contacto | " . $nombre_contacto;
    $txt = "Comentario: " . $comentario ."\n
        Mail de contacto: " . $email_contacto;
    $headers = "From: " .$email_contacto;

    $mailStatus = mail($to, $subject, $txt, $headers);
    // die(var_dump($mailStatus));
    if($mailStatus) {
        // Mensaje error
        $_SESSION['mensaje'] = "El formulario se ha enviado con exito!";
        $_SESSION['tipo_mensaje'] = "success";
    } else {
        // Mensaje error
        $_SESSION['mensaje'] = "Error al enviar formulario de contacto. Intente nuevamente mas tarde.";
        $_SESSION['tipo_mensaje'] = "warning";
    }
} else {
    // Mensaje error
    $_SESSION['mensaje'] = "Error al enviar formulario de contacto. Intente nuevamente mas tarde.";
    $_SESSION['tipo_mensaje'] = "warning";
}
// Redireccionar al form
header("Location: ../contacto.php");

?>