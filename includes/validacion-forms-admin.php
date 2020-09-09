<?php
// Funciones para validacion de datos de formularios
// include_once("../Data/usertype-enum.php");

// Nuevo
include_once($_SERVER['DOCUMENT_ROOT'] . 'EntornosGraficos_TP-Final/rutas.php');
include_once(DATA_PATH . "usertype-enum.php");

function test_input($data)
{ // Funcion que limpia los datos enviados en el form
    $data = trim($data); // Quitar espacios
    $data = stripslashes($data); // Quitar '\'
    $data = htmlspecialchars($data); // Formatear caracteres especiales
    return $data;
}

function validarDatosUsuario()
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
        $regexEnteros = "/^\d+$/"; // regex que valida solo numeros enteros
        $telefono = test_input($_POST["inputTelefono"]);
        $pregMatchValue = preg_match($telefono, $regexEnteros);

        if ($pregMatchValue == FALSE) {
            $_SESSION['telefErr'] = "Regex error.";
            $flag = false;
        } elseif ($pregMatchValue == 0) {
            // Si = 0 -> No es numero entero
            $_SESSION['telefErr'] = "El telefono debe contener unicamente digitos enteros.";
            $flag = false;
        }
    }

    if (empty($_POST["adminCheck"])) {
        $type = UserTypeEnum::Client;
    } else $type = UserTypeEnum::Administrator;

    return $flag;
}

function validarDatosZapatilla()
{
    // Variables
    $flag = true;
    global $nombre, $color, $precio, $img_path;

    /* Validar nombre (requerido) */
    if (empty($_POST['nombreZapatilla'])) {
        $_SESSION['modeloZapaErr'] = "El nombre/modelo es requerido";
        $flag = false;
    } else $nombre = test_input($_POST['nombreZapatilla']);

    /* Validar color */
    if (empty($_POST['colorZapatilla'])) $color = null;
    else $color = test_input($_POST['colorZapatilla']);

    /* Validar precio (solo numeros enteros) */
    if (!empty($_POST["precioZapatilla"])) {
        $regexDecimal = "/^\d*[.,]?\d*$/"; // regex que valida numero entero o decimal
        $precio = test_input($_POST["precioZapatilla"]);
        $valor = preg_match($regexDecimal, $precio);
        if ($valor === FALSE) {
            // preg_match = FALSE -> Error
            $_SESSION['precioZapaErr'] = "Error regex.";
            $flag = false;
        } elseif ($valor === 1) {
            // preg_match = 1 -> Encontro patron
            // Formatear ',' por '.'
            $precio = str_replace(",", ".", $precio);
            // $precio = preg_replace("/,/", "/./", $_POST['precioZapatilla']);
        } elseif ($valor === 0) {
            // preg_match = 0 -> No encontro patron -> Error
            $_SESSION['precioZapaErr'] = "El precio debe contener unicamente digitos numericos y '.' o ','";
            $flag = false;
        }
    } else $precio = null;


    /* Validar Imagen */
    // Guardar campo en variable local
    $image = $_FILES['fileZapa'];
    $uploadOk = 1; // Bandera

    // $_SESSION['errorArray'] = $image['error'];
    // Si el error es 'UPLOAD_ERR_NO_FILE' -> No hay archivo cargado
    if ($image['error'] != UPLOAD_ERR_NO_FILE) {
        // Validar extension
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg']; // Permitidas
        $mimeType = $image['type'];
        if (!in_array($mimeType, $allowedMimeTypes)) {
            $_SESSION['imgErr'] .= "Solo son validos archivos con formato JPG, JPEG y PNG.\n";
            $uploadOk = 0;
        }

        // Validar size
        $maxFileSize = 500000; // 500KB
        if ($image['size'] > $maxFileSize) {
            $_SESSION['imgErr'] .= "El archivo pesa mas de 500KB.\n";
            $uploadOk = 0;
        }

        // Validar si ya existe imagen
        if (file_exists(basename($image['name']))) {
            $_SESSION['imgErr'] .=  "El archivo que desea subir ya existe.\n";
            $uploadOk = 0;
        }

        // Si todo ok -> Guardar img en server
        if ($uploadOk !== 0 && $flag == TRUE) {
            $img_path = "Uploads/" . basename($image['name']); // Path que se guarda en la DB
            $directiorio_final = UPLOADS_PATH . basename($image['name']);

            if (move_uploaded_file($image['tmp_name'], $directiorio_final)) {
                $_SESSION['llego'] .= "El fichero es válido y se subió con éxito.";
            } else {
                $_SESSION['imgErr'] .= "Hubo un error al subir el archivo. \n" . $image['error'];
                $flag = false;
            }
        } else {
            $_SESSION['imgErr'] .= "El archivo no fue subido.";
            $flag = false;
        }
    } // No requerida, asi que no hay 'else'

    return $flag;
}
