<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
include(DAO_PATH . "db.php");
include(DATA_PATH . "data.usuario.php");

// Iniciar/Retomar sesion
session_start();

// Fetch usuario de sesion
if (isset($_SESSION['usuarioActual'])) $usuarioActual = $_SESSION['usuarioActual'];
else $usuarioActual = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Cabeceras -->
    <?php include(INCLUDES_PATH."styles.links.php") ?>

    <title>Registro de Administrador | Tibbonzapas</title>
</head>

<body>
    <!-- NavBar -->
    <?php include(INCLUDES_PATH."navbar.php"); ?>

    <!-- Content | Solo visible para usuario administrador -->
    <?php
    // Si hay usuario loggeado y es administrador
    if ( $usuarioActual != null &&
        $usuarioActual->get_tipo() == UserTypeEnum::Administrator) {
    ?>

    <div class="container mt-3">
        <div class="col justify-content-around">

            <!-- Mensaje alerta -->
            <?php if (isset($_SESSION['mensaje'])) { ?>
                <div class="alert alert-<?= $_SESSION['tipo_mensaje'] ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['mensaje'] ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php } ?>

            <div class="jumbotron">
                <h3 class="mb-3">
                    <i class="fas fa-user-plus"></i>
                    Complete datos de registro
                </h3>
                
                <!-- Formulario -->
                <form action="Forms/manejo.abm.usuarios.php" method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputName">Nombre:</label>
                            <input 
                                type="text" 
                                class="form-control <?php if (isset($_SESSION['nombreErr'])) { ?>is-invalid<?php } ?>" 
                                name="inputName" 
                                placeholder="Nicolas" 
                                required 
                                autofocus 
                            />
                            <?php if (isset($_SESSION['nombreErr'])) { ?>
                                <small class="invalid-feedback"><?= $_SESSION["nombreErr"] ?></small>
                            <?php } else { ?>
                                <small id="nombreHelp" class="form-text text-muted">Requerido.</small>
                            <?php } ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputApellido">Apellido:</label>
                            <input 
                                type="text" 
                                class="form-control <?php if (isset($_SESSION['apeErr'])) { ?>is-invalid<?php } ?>" 
                                name="inputApellido" 
                                placeholder="Gomez" 
                                required 
                            />
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
                            <input 
                                type="email" 
                                class="form-control <?php if (isset($_SESSION['emailErr'])) { ?>is-invalid<?php } ?>" 
                                name="inputEmail" 
                                placeholder="nicogomez@gmail.com"
                                required 
                            />
                            <?php if (isset($_SESSION['emailErr'])) { ?>
                                <small class="invalid-feedback"><?= $_SESSION["emailErr"] ?></small>
                            <?php } else { ?>
                                <small id="emailHelp" class="form-text text-muted">Requerido.</small>
                            <?php } ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputTelefono">Telefono <span class="text-muted">(opcional)</span>:</label>
                            <input 
                                type="text" 
                                class="form-control <?php if (isset($_SESSION['telefErr'])) { ?>is-invalid<?php } ?>"
                                name="inputTelefono" 
                                placeholder="543413555555" 
                            />
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
                            <input 
                                type="text" 
                                class="form-control <?php if (isset($_SESSION['usernameErr'])) { ?>is-invalid<?php } ?>"
                                name="inputUser" 
                                placeholder="NicoTibbon" 
                                required 
                                minlength="2" 
                                maxlength="10" 
                            />
                            <?php if (isset($_SESSION['usernameErr'])) { ?>
                                <div class="invalid-feedback"><?= $_SESSION["usernameErr"] ?></div>
                            <?php } else { ?>
                                <small id="usernameHelp" class="form-text text-muted">Entre 2 y 10 caracteres.</small>
                            <?php } ?>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="radioUserType">Tipo Usuario:</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="adminCheck" id="adminCheck" />
                                <label class="form-check-label" for="adminCheck">
                                    Administrador
                                </label>
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
                                placeholder="Contraseña" 
                                required 
                                minlength="4" 
                                maxlength="10" 
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
                                required 
                                minlength="4" 
                                maxlength="10" 
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

                    <!-- Limpiar mensajes de error -->
                    <?php 
                        if(isset($_SESSION['mensaje'])) unset($_SESSION['mensaje']); 
                        if(isset($_SESSION['tipo_mensaje'])) unset($_SESSION['tipo_mensaje']);        
                        if(isset($_SESSION['nombreErr'])) unset($_SESSION['nombreErr']); 
                        if(isset($_SESSION['apeErr'])) unset($_SESSION['apeErr']); 
                        if(isset($_SESSION['emailErr'])) unset($_SESSION['emailErr']); 
                        if(isset($_SESSION['telefErr'])) unset($_SESSION['telefErr']); 
                        if(isset($_SESSION['usernameErr'])) unset($_SESSION['usernameErr']); 
                        if(isset($_SESSION['passErr'])) unset($_SESSION['passErr']); 
                        if(isset($_SESSION['validarPassErr'])) unset($_SESSION['validarPassErr']); 
                    ?>

                    <div class="form-group col">
                        <button type="submit" name="save_admin" class="btn btn-success btn-block">
                            <i class="far fa-check-circle"></i>
                            Registrar
                        </button>
                    </div>
                    <div class="form-group col">
                        <button type="reset" class="btn btn-primary btn-block">
                            <i class="fas fa-eraser"></i>
                            Borrar
                        </button>
                    </div>
                </form>
            </div>
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

    <!-- Scripts -->
    <?php include(INCLUDES_PATH."scripts.php"); ?>

</body>

</html>