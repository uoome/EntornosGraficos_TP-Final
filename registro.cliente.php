<?php 
// Nuevo
include_once($_SERVER['DOCUMENT_ROOT'].'/EntornosGraficos_TP-Final/rutas.php');
include(DAO_PATH."db.php");
include(DATA_PATH."data.usuario.php"); // Necesario para que no crashee el navbar

// Iniciar/Retornar sesion
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<!-- Cabeceras -->
<?php include(INCLUDES_PATH."header.php") ?>

<body>
    <!-- NavBar -->
    <?php include(INCLUDES_PATH."navbar.php") ?>

    <!-- Content -->
    <div class="container mt-5">
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
                <form action="Forms/admin.alta.usuario.php" method="POST">
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
                    <div class="form-group">
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
                    <div class="form-group">
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
                    <div class="form-group col">
                        <button type="submit" name="save_client" class="btn btn-success btn-block">
                            <i class="far fa-check-circle"></i>
                            Registrarse
                        </button>
                    </div>
                    <div class="form-group col">
                        <button type="reset" name="reset" class="btn btn-primary btn-block">
                            <i class="fas fa-eraser"></i>
                            Borrar
                        </button>
                    </div>
                </form>

                <!-- Limpiar mensajes -->
                <?php 
                    if(isset($_SESSION['mensaje'])) unset($_SESSION['mensaje']); 
                    if(isset($_SESSION['nombreErr'])) unset($_SESSION['nombreErr']); 
                    if(isset($_SESSION['apeErr'])) unset($_SESSION['apeErr']); 
                    if(isset($_SESSION['emailErr'])) unset($_SESSION['emailErr']); 
                    if(isset($_SESSION['usernameErr'])) unset($_SESSION['usernameErr']); 
                    if(isset($_SESSION['passErr'])) unset($_SESSION['passErr']); 
                    if(isset($_SESSION['validarPassErr'])) unset($_SESSION['validarPassErr']); 
                ?>

            </div>
        </div>
    </div>

    <!-- Scripts -->
    <?php include(INCLUDES_PATH."scripts.php") ?>

</body>

</html>