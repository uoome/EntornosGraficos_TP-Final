<?php
// Includes
include("../includes/db.php");
include("../Data/usuario-data.php");

// Logica si hay POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Variables 
    $nombre = $apellido = $username = $password = $email = $telefono = $type = null;

    // Realizar validacion
    if (validarDatos()) {
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
        } else {
            // Mensaje error
            $_SESSION['mensaje'] = "Error: " . $query . "<br>" . $conn->error;
            $_SESSION['tipo_mensaje'] = "danger";
        }
    } else {
        $_SESSION['mensaje'] = "<strong>Ups!</strong> Complete los datos correctamente";
        $_SESSION['tipo_mensaje'] = "warning";
    }

    //Redireccionar al form
    header("Location: ../registro-administrador.php");
}


// Funciones

function test_input($data)
{ // Funcion que limpia los datos enviados en el form
    $data = trim($data); // Quitar espacios
    $data = stripslashes($data); // Quitar '\'
    $data = htmlspecialchars($data); // Formatear caracteres especiales
    return $data;
}

function validarDatos()
{
    $flag = true;
    global $nombre, $apellido, $username, $password, $email, $telefono, $type;

    if (empty($_POST["inputName"])) {
        $_SESSION['nombreErr'] = "El nombre es requerido";
        $flag = false;
    } else $nombre = test_input($_POST["inputName"]);

    if (empty($_POST["inputApellido"])) {
        $_SESSION['apeErr'] = "El apellido es requerido";
        $flag = false;
    } else $apellido = test_input($_POST["inputApellido"]);

    if (empty($_POST["inputEmail"])) {
        $_SESSION['emailErr'] = "El email es requerido";
        $flag = false;
    } else {
        $email = test_input($_POST["inputEmail"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['emailErr'] = "Formato de mail incorrecto";
            $flag = false;
        }
    }

    if (empty($_POST["inputUser"])) {
        $_SESSION['usernameErr'] = "El usuario es requerido";
        $flag = false;
    } else {
        $username = test_input($_POST["inputUser"]);
        $longitudUser = strlen($username);
        if ($longitudUser < 2 || $longitudUser > 10) {
            $_SESSION['usernameErr'] = "El usuario debe tener entre 2 y 10 caracteres";
            $flag = false;
        }
    }

    if (empty($_POST["inputPass"])) {
        $_SESSION['passErr'] = "La contraseña es requerida";
        $flag = false;
    } else {
        $password = test_input($_POST["inputPass"]);
        $longitudPass = strlen($password);
        if ($longitudPass < 4 || $longitudPass > 10) {
            $_SESSION['passErr'] = "La contraseña debe tener entre 4 y 10 caracteres";
            $flag = false;
        }
    }

    $validarPass = test_input($_POST["inputValidarPass"]);
    if (strcmp($password, $validarPass) !== 0) {
        $_SESSION['validarPassErr'] = "La contraseña y su validacion deben coincidir";
        $flag = false;
    }

    if (!empty($_POST["inputTelefono"])) {
        $regex = "/\D+/"; // regex que busca letras en el texto
        $telefono = test_input($_POST["inputTelefono"]);
        // Si encuntra letras -> preg_match = 1
        if (preg_match($telefono, $regex) === 1) {
            $_SESSION['telefErr'] = "El telefono debe contener unicamente digitos enteros";
            $flag = false;
        }
    }

    if (empty($_POST["adminCheck"])) {
        $type = UserTypeEnum::Visitor;
    } else $type = UserTypeEnum::Administrator;

    return $flag;
}
