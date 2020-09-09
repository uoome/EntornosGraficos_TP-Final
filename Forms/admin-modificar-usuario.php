<?php
// Anterior
// include("../includes/db.php");
// include("../includes/validacion-forms-admin.php");

// Nuevo
include_once($_SERVER['DOCUMENT_ROOT'].'EntornosGraficos_TP-Final/rutas.php');
include(INCLUDES_PATH."db.php");
include_once(INCLUDES_PATH."validacion-forms-admin.php");

// Si hay ID
if (isset($_GET['id'])) {
    // Guardar ID
    $id = $_GET['id'];

    // Validar que existe el usuario
    $existentUserQuery = "SELECT * FROM `usuario` WHERE id_usuario = $id;";
    $existentUser = $conn->query($existentUserQuery);

    if ($existentUser->num_rows == 1) {
        $data = $existentUser->fetch_assoc();

        // Pagina

?>
        <!DOCTYPE html>
        <html lang="en">

        <!-- Cabeceras -->
        <?php include("../includes/header.php") ?>

        <body>
            <!-- NavBar -->
            <?php include("../includes/navbar.php") ?>

            <!-- Content -->
            <div class="container mt-3">
                <div class="col justify-content-around">

                    <div class="jumbotron">
                        <h3 class="mb-3">
                            <i class="fas fa-user-plus"></i>
                            Modificacion de Usuario
                        </h3>

                        <!-- Formulario -->
                        <form action="#" method="POST">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputName">Nombre:</label>
                                    <input 
                                        type="text" 
                                        class="form-control <?php if (isset($_SESSION['nombreErr'])) { ?>is-invalid<?php } ?>" 
                                        name="inputName" 
                                        placeholder="Nicolas" 
                                        value="<?= $data["nombre"] ?>"
                                        required 
                                        autofocus />
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
                                        value="<?= $data["apellido"] ?>"
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
                                    <label for="inputTelefono">Telefono:</label>
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

                            <div class="form-group col">
                                <button type="submit" name="modify_user" class="btn btn-success btn-block">
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
                    </div>
                </div>
            </div>

            <!-- Scripts -->
            <?php include("../includes/scripts.php") ?>

        </body>

        </html>

<?php
    } else {
        // Mensaje error
        $_SESSION['mensaje'] = "Error modificar usuario: " . $conn->error;
        $_SESSION['tipo_mensaje'] = "danger";
    }

    // Redireccionar al form
    // header("Location: ../panel-usuarios.php");
}
?>