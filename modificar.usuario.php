<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
include_once(DAO_PATH . "db.php"); // DB
include_once(DAO_PATH . "dao.usuario.php"); // Usuario service
include_once(DATA_PATH . "data.usuario.php"); // Usuario Data

// Si hay ID
if (isset($_GET['id'])) {
    // Guardar ID
    $id = $_GET['id'];

    // Iniciar/Retomar sesion
    session_start();

    // Fetch usuario sesion
    if (isset($_SESSION['usuarioActual'])) {
        $usuarioActual = $_SESSION['usuarioActual'];
        // Validar que existe el usuario
        $usuarioService = new UsuarioService();
        $usuario = $usuarioService->getUser($id);
    } else $usuarioActual = null;
} else {
    // Mensaje error
    $_SESSION['mensaje'] = "Error de request.";
    $_SESSION['tipo_mensaje'] = "danger";
    //Redireccionar al form
    header("Location: ../panel.usuarios.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!-- Botstrap CSS -->
    <link rel="stylesheet" href="CSS/Bootstrap/css/bootstrap.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="CSS/fontawesome-free-5.14.0-web/css/all.css" />
    <!-- Icon -->
    <link rel="shortcut icon" href="IMG/favicon.ico" type="image/x-icon">
    <!-- Custom CSS -->
    <style>
        .container {
            padding: 20px;
        }

        input[type="number"] {
            width: 20%;
        }
    </style>
    <!-- JavaScript -->
    <script>
        function enablePasswordChange(checkbox) {
            var inputPass = document.getElementById('inputPass');
            var inputValPass = document.getElementById('inputValidarPass');

            if(checkbox.checked) {
                console.log("Habilitar cambio de pass");
                console.log(inputPass);
                console.log(inputValPass);
                inputPass.disabled = false;
                inputValPass.disabled = false;
            } else {
                console.log("Deshabilitar cambio de pass");
                inputPass.disabled = true;
                inputValPass.disabled = true;
            }
        }
    </script>

    <title>ABM Modificar Usuario | Tibbonzapas</title>
</head>

<body>
    <!-- NavBar -->
    <?php include(INCLUDES_PATH . "navbar.php"); ?>

    <!-- Content | Solo visible para usuario administrador -->
    <?php
    // Si hay usuario loggeado y es administrador
    if (
        $usuarioActual != null &&
        $usuarioActual->get_tipo() == UserTypeEnum::Administrator
    ) {
    ?>

        <div class="container mt-3">
            <div class="col justify-content-around">

                <!-- Si hay usuario a modificar -->
                <?php if ($usuario != null) { ?>

                    <div class="jumbotron">
                        <h3 class="mb-3">
                            <i class="fas fa-user-plus"></i>
                            Modificacion de Usuario
                        </h3>

                        <hr />

                        <!-- Mensaje alerta -->
                        <?php if (isset($_SESSION['mensaje'])) { ?>
                            <div class="alert alert-<?= $_SESSION['tipo_mensaje'] ?> alert-dismissible fade show" role="alert">
                                <?= $_SESSION['mensaje'] ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php } ?>

                        <!-- Formulario -->
                        <form action="Forms/manejo.abm.usuarios.php" method="POST">
                            <input type="hidden" name="idUserToUpdate" value="<?= $id ?>">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputName">Nombre:</label>
                                    <input type="text" class="form-control <?php if (isset($_SESSION['nombreErr'])) { ?>is-invalid<?php } ?>" name="inputName" placeholder="Nicolas" value="<?= $usuario->get_nombre() ?>" required autofocus />
                                    <?php if (isset($_SESSION['nombreErr'])) { ?>
                                        <small class="invalid-feedback"><?= $_SESSION["nombreErr"] ?></small>
                                    <?php } else { ?>
                                        <small id="nombreHelp" class="form-text text-muted">Requerido.</small>
                                    <?php } ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputApellido">Apellido:</label>
                                    <input type="text" class="form-control <?php if (isset($_SESSION['apeErr'])) { ?>is-invalid<?php } ?>" name="inputApellido" value="<?= $usuario->get_apellido() ?>" placeholder="Gomez" required />
                                    <?php if (isset($_SESSION['apeErr'])) { ?>
                                        <div class="invalid-feedback"><?= $_SESSION["apeErr"] ?></div>
                                    <?php } else { ?>
                                        <small id="apellidoHelp" class="form-text text-muted">Requerido.</small>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail">Email:</label>
                                    <input type="email" class="form-control <?php if (isset($_SESSION['emailErr'])) { ?>is-invalid<?php } ?>" name="inputEmail" value="<?= $usuario->get_email() ?>" placeholder="nicogomez@gmail.com" required />
                                    <?php if (isset($_SESSION['emailErr'])) { ?>
                                        <small class="invalid-feedback"><?= $_SESSION["emailErr"] ?></small>
                                    <?php } else { ?>
                                        <small id="emailHelp" class="form-text text-muted">Requerido.</small>
                                    <?php } ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputTelefono">Telefono:</label>
                                    <input type="text" class="form-control <?php if (isset($_SESSION['telefErr'])) { ?>is-invalid<?php } ?>" name="inputTelefono" value="<?= $usuario->get_telefono() ?>" placeholder="543413555555" />
                                    <?php if (isset($_SESSION['telefErr'])) { ?>
                                        <div class="invalid-feedback"><?= $_SESSION["telefErr"] ?></div>
                                    <?php } else { ?>
                                        <small id="telefonoHelp" class="form-text text-muted">Solo numeros enteros.</small>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputUser">Usuario:</label>
                                    <input type="text" class="form-control <?php if (isset($_SESSION['usernameErr'])) { ?>is-invalid<?php } ?>" name="inputUser" value="<?= $usuario->get_username() ?>" placeholder="NicoTibbon" required minlength="2" maxlength="10" />
                                    <?php if (isset($_SESSION['usernameErr'])) { ?>
                                        <div class="invalid-feedback"><?= $_SESSION["usernameErr"] ?></div>
                                    <?php } else { ?>
                                        <small id="usernameHelp" class="form-text text-muted">Entre 2 y 10 caracteres.</small>
                                    <?php } ?>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="form-group">
                                        <label for="radioUserType">Tipo Usuario:</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" name="adminCheck" id="adminCheck" />
                                        <label class="form-check-label" for="adminCheck">
                                            Administrador
                                        </label>
                                        <small id="adminHelp" class="form-text text-muted">
                                            Tildar si es usuario administrador.
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="form-group">
                                        <label for="radioPasswordChange">Cambiar Contraseña:</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="hidden" name="passCheck" value="off" />
                                        <input 
                                            type="checkbox" 
                                            class="form-check-input" 
                                            id="passCheck" 
                                            name="passCheck" 
                                            value="on"
                                            onclick="enablePasswordChange(this)"
                                        />
                                        <label class="form-check-label" for="passCheck">
                                            Cambiar
                                        </label>
                                        <small id="passChangeHelp" class="form-text text-muted">
                                            Tildar si desea modificar la contraseña.
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputPass">Contraseña:</label>
                                    <input 
                                        type="password" 
                                        class="form-control <?php if (isset($_SESSION['passErr'])) { ?>is-invalid<?php } ?>" 
                                        name="inputPass" 
                                        id="inputPass"
                                        placeholder="Contraseña" 
                                        required 
                                        minlength="4" 
                                        maxlength="10" 
                                        disabled
                                    />
                                    <?php if (isset($_SESSION['passErr'])) { ?>
                                        <div class="invalid-feedback"><?= $_SESSION["passErr"] ?></div>
                                    <?php } else { ?>
                                        <small id="passwordHelp" class="form-text text-muted">Entre 4 y 10 caracteres.</small>
                                    <?php } ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputValidarPass">Validar contraseña:</label>
                                    <input 
                                        type="password" 
                                        class="form-control <?php if (isset($_SESSION['validarPassErr'])) { ?>is-invalid<?php } ?>" 
                                        name="inputValidarPass" 
                                        id="inputValidarPass"
                                        required 
                                        minlength="4" 
                                        maxlength="10" 
                                        disabled
                                    />
                                    <?php if (isset($_SESSION['validarPassErr'])) { ?>
                                        <div class="invalid-feedback"><?= $_SESSION["validarPassErr"] ?></div>
                                    <?php } else { ?>
                                        <small id="validarPassHelp" class="form-text text-muted">
                                            Debe ser igual a la contraseña ingresada.
                                        </small>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="form-group col">
                                <button type="submit" name="update_user" class="btn btn-success btn-block">
                                    <i class="far fa-check-circle"></i>
                                    Modificar
                                </button>
                            </div>
                            <div class="form-group col">
                                <button type="reset" class="btn btn-primary btn-block">
                                    <i class="fas fa-eraser"></i>
                                    Borrar
                                </button>
                            </div>
                        </form>
                        <!-- Limpiar mensajes -->
                        <?php 
                            if(isset($_SESSION['nombreErr'])) unset($_SESSION['nombreErr']); 
                            if(isset($_SESSION['apeErr'])) unset($_SESSION['apeErr']); 
                            if(isset($_SESSION['emailErr'])) unset($_SESSION['emailErr']); 
                            if(isset($_SESSION['usernameErr'])) unset($_SESSION['usernameErr']); 
                            if(isset($_SESSION['telefErr'])) unset($_SESSION['telefErr']); 
                            if(isset($_SESSION['passErr'])) unset($_SESSION['passErr']); 
                            if(isset($_SESSION['validarPassErr'])) unset($_SESSION['validarPassErr']); 
                        ?>
                    </div>

                    <!-- Si no hay usuario a modificar -->
                <?php } else {
                    $_SESSION['mensaje'] = "El registro a modificar no existe.";
                    $_SESSION['tipo_mensaje'] = "danger";
                    //Redireccionar al form
                    header("Location: ../panel.usuarios.php");
                } ?>
            </div>
        </div>

        <!-- Mensaje de autorizacion -->
    <?php } else { ?>
        <div class="container mt-3">
            <div class="alert alert-danger text-center" role="alert">
                No esta autorizado a estar en esta seccion!
            </div>
        </div>
    <?php } ?>

    <!-- Limpiar mensajes de sesion -->
    <?php 
        if(isset($_SESSION['mensaje'])) unset($_SESSION['mensaje']); 
        if(isset($_SESSION['tipo_mensaje'])) unset($_SESSION['tipo_mensaje']);        
    ?>

    <!-- Scripts -->
    <?php include(INCLUDES_PATH . "scripts.php") ?>

</body>

</html>