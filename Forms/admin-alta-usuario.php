<?php
// Includes
// include_once("includes/db.php");
// include("../includes/validacion-forms-admin.php");

// Nuevo
include_once($_SERVER['DOCUMENT_ROOT'].'EntornosGraficos_TP-Final/rutas.php');
include_once(INCLUDES_PATH."db.php");
include_once(INCLUDES_PATH."validacion-forms-admin.php");

// Logica si hay POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Variables 
    $nombre = $apellido = $username = $password = $email = $telefono = $type = null;

    // Realizar validacion
    if (validarDatosUsuario()) {
        // Crear usuario y cargar datos
        // $new_admin = new Usuario();
        // $new_admin->set_nombre($nombre);
        // $new_admin->set_apellido($apellido);
        // $new_admin->set_email($email);
        // $new_admin->set_username($username);
        // $new_admin->set_password($password);
        // $new_admin->set_telefono($telefono);
        // $new_admin->set_tipo($type);

        // Ejecutar Query
        $sql = "INSERT INTO tibbonzapas.usuario (nombre, apellido, username, password, email, telefono, tipo_usuario) 
            VALUES ('$nombre', '$apellido', '$username', '$password', '$email', '$telefono', '$type')";

        if ($conn->query($sql) === TRUE) {
            // Mensaje exito
            $_SESSION['mensaje'] = "Usuario creado con exito !";
            $_SESSION['tipo_mensaje'] = "success";
            $altaOk = true;
        } else {
            // Mensaje error
            $_SESSION['mensaje'] = "Error: " . $query . "<br>" . $conn->error;
            $_SESSION['tipo_mensaje'] = "danger";
            $altaOk = false;
        }
    } else {
        $_SESSION['mensaje'] = "<strong>Ups!</strong> Complete los datos correctamente";
        $_SESSION['tipo_mensaje'] = "warning";
    }

    //Redireccionar al form correspondiente
    // Si es registro por admin -> Volver a la misma pag
    if(isset($_POST['save_admin'])) header("Location: ../registro-administrador.php");

    // Si es registro de cliente 
    if(isset($_POST['save_client'])){
        // Validar registro correcto y redireccionar a 'login.php'
        if($altaok === TRUE) header("Location: ../login.php");
        // Sino redireccionar a 'registro-cliente.php'
        else header("Location: ../registro-cliente.php");
    }
} else {
    // Mensaje error
    $_SESSION['mensaje'] = "Error al enviar formulario por metodo POST.\n";
    $_SESSION['tipo_mensaje'] = "danger";
}

?>