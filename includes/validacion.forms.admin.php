<?php
/**
 * Archivo que contiene:
 *  Metodos para el manejo de datos procedentes de formularios.
 *  Metodos para validacion de datos de formularios.
 */

include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
include_once(DATA_PATH . "usertype.enum.php");

function test_input($data)
{ // Funcion que limpia los datos enviados en el form
    $data = trim($data); // Quitar espacios
    $data = stripslashes($data); // Quitar '\'
    $data = htmlspecialchars($data); // Formatear caracteres especiales
    return $data;
}

/**
 * Funcion que valida los datos de un formulario de usuario
 * @return bool
 */
function validarDatosUsuario()
{
    $flag = true;
    global $nombre, $apellido, $username, $password, $email, $telefono, $type;

    // Validar nombre
    if (empty($_POST["inputName"])) {
        $_SESSION['nombreErr'] = "El nombre es requerido";
        $flag = false;
    } else $nombre = test_input($_POST["inputName"]);

    // Validar apellido
    if (empty($_POST["inputApellido"])) {
        $_SESSION['apeErr'] = "El apellido es requerido";
        $flag = false;
    } else $apellido = test_input($_POST["inputApellido"]);

    // Validar email
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

    // Validar usuario
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


    /* Validar checkbox 'passCheck' */
    // Si esta -> Update user, password no requerida
    if(isset($_POST['passCheck'])) {
        // Si checked -> Password requerida
        if($_POST['passCheck'] == 'on') {
            // Validar 'inputPass'
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

            // Validar 'validarPass'
            $validarPass = test_input($_POST["inputValidarPass"]);
            if (strcmp($password, $validarPass) !== 0) {
                $_SESSION['validarPassErr'] = "La contraseña y su validacion deben coincidir";
                $flag = false;
            }
        } elseif($_POST['passCheck'] == 'off')  // Si unchecked -> Password no requerida
            $password = null;
        else 
            die("Valor erroneo en passCheck");

    } else { // Sino -> Insert User -> password requerida
        // Validar password
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

        // Validar 'validarPass'
        $validarPass = test_input($_POST["inputValidarPass"]);
        if (strcmp($password, $validarPass) !== 0) {
            $_SESSION['validarPassErr'] = "La contraseña y su validacion deben coincidir";
            $flag = false;
        }
    }
    

    // Validar telefono | No funca la regex
    /*
    if (!empty($_POST["inputTelefono"])) {
        $regexEnteros = "/^\d+$/"; // regex que valida solo numeros enteros | No funca
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
    */

    // Validar tipoUsuario
    if (!isset($_POST["adminCheck"]) || empty($_POST["adminCheck"])) {
        $type = UserTypeEnum::Client;
    } else $type = UserTypeEnum::Administrator;

    return $flag;
}

/**
 * Funcion que valida los datos de un formulario de zapatilla
 * @return bool
 */
function validarDatosZapatilla()
{
    // Variables
    $flag = true;
    global $id, $nombre, $precio, $descripcion, $img_path, $sexo;

    /* Validar nombre (requerido) */
    if (empty($_POST['nombreZapatilla'])) {
        $_SESSION['modeloZapaErr'] = "El nombre/modelo es requerido";
        $flag = false;
    } else $nombre = test_input($_POST['nombreZapatilla']);

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
            // die(var_dump($precio));
            // $precio = preg_replace("/,/", "/./", $_POST['precioZapatilla']);
        } elseif ($valor === 0) {
            // preg_match = 0 -> No encontro patron -> Error
            $_SESSION['precioZapaErr'] = "El precio debe contener unicamente digitos numericos y '.' o ','";
            $flag = false;
        }
    } else $precio = null;

    /* Validar descripcion */
    if(empty($_POST['descripcionZapatilla'])) $descripcion = null;
    else {
        $descripcion = stripslashes($_POST['descripcionZapatilla']); // Quitar '\'
        $descripcion = htmlspecialchars($descripcion); // Formatear caracteres especiales
    }

    /* Validar Tipo */
    if(isset($_POST['selectTipo'])) 
        if($_POST['selectTipo'] == "U") $sexo = null; 
        else $sexo = $_POST['selectTipo'];

    /* Validar Imagen */
    if(isset($_POST['checkIMG'])) {
        // Si checked -> Guardar imagen
        if($_POST['checkIMG'] == 'on') {
            // Guardar campo en variable local
            $image = $_FILES['fileZapa'];
            // die(var_dump($image));
            $uploadOk = 1; // Bandera
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
                    
                    // Si hay error al subir el archivo -> Mensaje error
                    if (!move_uploaded_file($image['tmp_name'], $directiorio_final)) {
                        $_SESSION['imgErr'] .= "Hubo un error al subir el archivo. \n" . $image['error'];
                        $flag = false;
                    } 
                } else { // Sino, error en carga de datos -> no subir archivo
                    $_SESSION['imgErr'] .= "El archivo no fue subido.";
                    $flag = false;
                }
            }
        } elseif($_POST['checkIMG'] == 'off') {
            $img_path = null;
            $flag = false;
        } 
    }

    return $flag;
}
